<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="logs")
 */
class Logs
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(name="identifier")
	 */
	private $identifier;

	/**
	 * @ORM\Column(name="url")
	 */
	private $url;

	/**
	 * @ORM\Column(name="request")
	 */
	private $request;

	/**
	 * @ORM\Column(name="response")
	 */
	private $response;

	/**
	 * @ORM\Column(name="responseStatusCode")
	 */
	private $responseStatusCode;

	/**
	 * @ORM\Column(name="created")
	 */
	private DateTime $created;

	public function __construct()
	{
		$this->created = new DateTime();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getidentifier()
	{
		return $this->identifier;
	}

	public function setidentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	public function geturl()
	{
		return $this->url;
	}

	public function seturl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function getrequest()
	{
		return $this->request;
	}

	public function setrequest($request)
	{
		$this->request = $request;
		return $this;
	}

	public function setresponse($response)
	{
		$this->response = $response;
		return $this;
	}

	public function getresponse()
	{
		return $this->response;
	}

	public function setresponseStatusCode($responseStatusCode)
	{
		$this->responseStatusCode = $responseStatusCode;
		return $this;
	}

	public function getresponseStatusCode()
	{
		return $this->responseStatusCode;
	}

	public function getCreated()
	{
		return $this->created;
	}
}
