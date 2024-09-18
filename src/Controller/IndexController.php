<?php

namespace App\Controller;

use App\Entity\UsjTicket;
use App\Form\UsjTicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;


use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends AbstractController
{
	private $usjTicketEntity;
	private $client;
	private $SUYOOL_API_HOST;


	// Inject the blogs EntityManagerInterface
	public function __construct(EntityManagerInterface $usjTicketEntity, HttpClientInterface $client)
	{
		$this->usjTicketEntity = $usjTicketEntity;
		$this->client = $client;
		if ($_ENV['APP_ENV'] == 'prod') {
			$this->SUYOOL_API_HOST = 'https://externalservices.nicebeach-895ccbf8.francecentral.azurecontainerapps.io/api/GlobalAPIs/UsjPayment/InitiatePaymentRequest';
		} else {
			$this->SUYOOL_API_HOST = 'http://10.20.80.62/SuyoolGlobalApi/api/UsjPayment/InitiatePaymentRequest';
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
		$error = null;

		$parameters = [
			'barBgColor' => 'barBlue'
		];
		$parameters['faq'] = [
			"ONE" => [
				"Title" => "HOW_CAN_I_1",
				"Desc" => "HOW_CAN_I_2"
			],
			"TWO" => [
				"Title" => "HOW_CAN_I_3",
				"Desc" => "HOW_CAN_I_4"
			],
			"THREE" => [
				"Title" => "HOW_CAN_I_5",
				"Desc" => "HOW_CAN_I_6"
			],
			"FOUR" => [
				"Title" => "HOW_CAN_I_7",
				"Desc" => "HOW_CAN_I_8"
			],
			"FIVE" => [
				"Title" => "HOW_CAN_I_9",
				"Desc" => "HOW_CAN_I_10"
			],
		];
		$parameters['title'] = "Get 12% OFF* At Mike Sport When Paying With Suyool QR";
		$parameters['desc'] = "Shop at any Mike Sport branch from June 1 to July 31, pay with Suyool QR, and enjoy 12% OFF* your favorite brands automatically at checkout. No additional steps needed, just 3 simple steps to benefit!";
		$parameters['descmeta'] = "Get 12% OFF* At Mike Sport When Paying With Suyool QR";
		$parameters['metaimage'] = "build/images/mikesportpr/mikesportprMeta.jpg";


		if ($form->isSubmitted() && $form->isValid()) {

			$data = $form->getData();

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
				"merchantID" => 50,
				"secureHash" => $secureHash
			];
			// dd($body);
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
				// $content = $response->toArray();

				if ($statusCode == 200) {
					$decodedContent = json_decode($content, true);

					$additionalResponse = $decodedContent['data'];

					$additionalResponseDecoded = json_decode($additionalResponse, true);

					$code = $additionalResponseDecoded['AuthCode'];
					// $newredirect = new RedirectResponse("https://suyool.com/$code");
					$newredirect = new RedirectResponse("http://suyool.lss/$code");
					return $newredirect;
				} else {
					$error = "Une erreur s'est produite lors de l'envoi du formulaire. Veuillez réessayer.";

					$form = $this->createForm(UsjTicketType::class);
					return $this->render('base.html.twig', [
						'parameters' => $parameters,
						'form' => $form->createView(),
						'errordescription' => $error
					]);
				}
			} catch (\Exception $e) {
				$error = "Une erreur s'est produite lors de l'envoi du formulaire. Veuillez réessayer.";

				$form = $this->createForm(UsjTicketType::class);
				return $this->render('base.html.twig', [
					'parameters' => $parameters,
					'form' => $form->createView(),
					'errordescription' => $error
				]);
				return new JsonResponse([
					'message' => 'An error occurred: ' . $e->getMessage(),
					'status' => 'error'
				], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
			}
		}

		return $this->render('base.html.twig', [
			'parameters' => $parameters,
			'form' => $form->createView(),
			'errordescription' => $error
		]);
	}
}
