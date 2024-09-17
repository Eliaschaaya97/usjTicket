<?php

namespace App\Form;

use App\Entity\UsjTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class UsjTicketType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('quantity', IntegerType::class, [
				'required' => true,
				'attr' => [
					'min' => 1,
					'step' => 1,
					'id' => 'amount-input',
					'placeholder' => 'Enter quantity',
				],
				'data' => 1,
				'constraints' => [
					new Positive(['message' => 'The amount must be a positive number.']),
				],
			])
			->add('email', EmailType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'Example@example.com',
				],
			])
			->add('phoneNumber', IntegerType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => '+961 xx xxx xxx',
				],
				'constraints' => [
					new Positive(['message' => 'The phone number must be a positive number.']),
				],
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => UsjTicket::class,
		]);
	}
}
