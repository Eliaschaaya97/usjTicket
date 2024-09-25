<?php

namespace App\Controller;

use App\Entity\UsjTicket;
use App\Entity\Logs;
use App\Form\UsjTicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Service\LogsService;
use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends AbstractController
{
	private $usjTicketEntity;
	private $client;
	private $SUYOOL_API_HOST;
	private $SUYOOL_MERCHANT;
	private $SUYOOL_REDIRECT;


	// Inject the blogs EntityManagerInterface
	public function __construct(EntityManagerInterface $usjTicketEntity, HttpClientInterface $client)
	{
		$this->usjTicketEntity = $usjTicketEntity;
		$this->client = $client;
		if ($_ENV['APP_ENV'] == 'prod') {
			$this->SUYOOL_API_HOST = 'https://externalservices.nicebeach-895ccbf8.francecentral.azurecontainerapps.io/api/GlobalAPIs/UsjPayment/InitiatePaymentRequest';
			$this->SUYOOL_MERCHANT = 50;
			$this->SUYOOL_REDIRECT = "https://suyool.com/";
			// $this->SUYOOL_REDIRECT = "http://suyool.lss/";
		} else {
			$this->SUYOOL_API_HOST = 'http://10.20.80.62/SuyoolGlobalApi/api/UsjPayment/InitiatePaymentRequest';
			$this->SUYOOL_MERCHANT = 26;
			$this->SUYOOL_REDIRECT = "http://suyool.lss/";
		}
	}


	/**
	 * @Route("/", name="app_usj_ticket")
	 * @Route("/submit", name="app_usj_ticket_form", methods="POST")
	 */
	public function index(Request $request)
	{

		$form = $this->createForm(UsjTicketType::class);
		$form->handleRequest($request);
		$popup = false;
		$error = null;

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			$recaptchaResponse = $request->request->get('g-recaptcha-response');
			$recaptcha = new ReCaptcha('6LdpR84pAAAAAAagSt6oNM9IscP7ATwRQymVjEkP');
			$recaptchaResult = $recaptcha->verify($recaptchaResponse);
			if ($recaptchaResult->isSuccess()) {

				$newTicket = new UsjTicket();
				$newTicket->setEmail($data->getEmail());
				$newTicket->setPhoneNumber($data->getPhoneNumber());
				$newTicket->setQuantity($data->getQuantity());
				$newTicket->setTotalPrice($data->getQuantity() * 250);
				$phoneNumber = (string)$data->getPhoneNumber();

				if (strpos($phoneNumber, '9') !== 0) {
					$phoneNumber = '961' . $phoneNumber;
				}

				$concat = $phoneNumber . $_ENV['CERTIFICATE'];
				$secureHash = base64_encode(hash('sha512', $concat, true));
				$body = [
					"currencyID" => 1,
					"mobileNo" => "$phoneNumber",
					"amount" => ($data->getQuantity() * 250),
					"merchantID" => $this->SUYOOL_MERCHANT,
					"secureHash" => $secureHash
				];


				try {
					$this->usjTicketEntity->persist($newTicket);
					$this->usjTicketEntity->flush();
					$error = "Le form a été soumis avec succès";

					$response = $this->client->request(
						'POST',
						$this->SUYOOL_API_HOST,
						[
							'json' => $body
						]
					);

					$statusCode = $response->getStatusCode();
					$content = $response->getContent();

					$content = $response->toArray();
					$pushlog = new LogsService($this->usjTicketEntity);
					$pushlog->pushLogs(new Logs, "USJTicket", $body, $content, $this->SUYOOL_API_HOST, $statusCode);

					if ($statusCode == 200 && $content['flagCode'] == 4) {
						$popup = true;
						$form = $this->createForm(UsjTicketType::class);
						return $this->render('base.html.twig', [
							'form' => $form->createView(),
							'errordescription' => $error,
							'popup' => $popup
						]);
					} else if ($statusCode == 200 && $content['flagCode'] == 1) {

						$additionalResponse = $content['data'];

						$additionalResponseDecoded = json_decode($additionalResponse, true);

						$code = $additionalResponseDecoded['AuthCode'];

						$newredirect = new RedirectResponse($this->SUYOOL_REDIRECT . $code);
						return $newredirect;
					} else {
						$error = "Une erreur s'est produite lors de l'envoi du formulaire. Veuillez réessayer.";

						$form = $this->createForm(UsjTicketType::class);
						return $this->render('base.html.twig', [
							// 'parameters' => $parameters,
							'form' => $form->createView(),
							'errordescription' => $error,
							'popup' => $popup

						]);
					}
				} catch (\Exception $e) {
					$error = "Une erreur s'est produite lors de l'envoi du formulaire. Veuillez réessayer.";

					$form = $this->createForm(UsjTicketType::class);
					return $this->render('base.html.twig', [
						// 'parameters' => $parameters,
						'form' => $form->createView(),
						'errordescription' => $error,
						'popup' => $popup

					]);
					return new JsonResponse([
						'message' => 'An error occurred: ' . $e->getMessage(),
						'status' => 'error'
					], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
				}
			}
		}

		return $this->render('base.html.twig', [
			// 'parameters' => $parameters,
			'form' => $form->createView(),
			'errordescription' => $error,
			'popup' => $popup

		]);
	}
}
