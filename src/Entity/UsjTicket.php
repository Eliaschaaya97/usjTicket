<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usjTicket")
 */
class UsjTicket
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(name="amount")
	 */
	private $amount;

	/**
	 * @ORM\Column(name="email")
	 */
	private $email;

	/**
	 * @ORM\Column(name="totalPrice")
	 */
	private $totalPrice;

	/**
	 * @ORM\Column(name="phoneNumber")
	 */
	private $phoneNumber;

	/**
	 * @ORM\Column(name="created", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
	 */
	private $created;

	/**
	 * @ORM\Column(name="updated", type="datetime", options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
	 */
	private $updated;

	public function getId()
	{
		return $this->id;
	}


	public function getAmount()
	{
		return $this->amount;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}


	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	public function setTotalPrice($totalPrice)
	{
		$this->totalPrice = $totalPrice;
		return $this;
	}


	public function getPhoneNumber()
	{
		return $this->phoneNumber;
	}

	public function setPhoneNumber($phoneNumber)
	{
		$this->phoneNumber = $phoneNumber;
		return $this;
	}

	// public function getCreated()
	// {
	// 	return $this->created;
	// }

	// public function setCreated($created)
	// {
	// 	$this->created = $created;
	// 	return $this;
	// }

	// public function getUpdated()
	// {
	// 	return $this->updated;
	// }

	// public function setUpdated($updated)
	// {
	// 	$this->updated = $updated;
	// 	return $this;
	// }
}
