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

class IndexController extends AbstractController
{
	private $usjTicketEntity;

	// Inject the blogs EntityManagerInterface
	public function __construct(EntityManagerInterface $usjTicketEntity)
	{
		$this->usjTicketEntity = $usjTicketEntity;
	}


	/**
	 * @Route("/usjticket", name="app_usj_ticket")
	 * @Route("/usjticket/submit", name="app_usj_ticket_form", methods="POST")
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
			$newTicket->setAmount($data->getAmount());
			$newTicket->setTotalPrice($data->getAmount() * 250);


			try {
				$this->mr->persist($newTicket);
				$this->mr->flush();
				$error = "Form successfully submitted";
				$form = $this->createForm(UsjTicketType::class);
				return $this->render('usjticket/index.html.twig', [
					'parameters' => $parameters,
					'form' => $form->createView(),
					'errordescription' => $error
				]);
			} catch (\Exception $e) {
				$error = "Email and number are required";
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
