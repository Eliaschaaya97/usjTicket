<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logs")
 */
class Log
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text", name="identifier")
	 */
	private $identifier;

	/**
	 * @ORM\Column(type="text", name="url")
	 */
	private $url;

	/**
	 * @ORM\Column(type="text", name="request")
	 */
	private $request;

	/**
	 * @ORM\Column(type="text", name="response")
	 */
	private $response;

	/**
	 * @ORM\Column(type="integer", name="responseStatusCode", nullable=true)
	 */
	private $responseStatusCode;

	public function getId()
	{
		return $this->id;
	}

	public function getIdentifier()
	{
		return $this->identifier;
	}

	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function setRequest($request)
	{
		$this->request = $request;
		return $this;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function setResponse($response)
	{
		$this->response = $response;
		return $this;
	}

	public function getResponseStatusCode()
	{
		return $this->responseStatusCode;
	}

	public function setResponseStatusCode($responseStatusCode)
	{
		$this->responseStatusCode = $responseStatusCode;
		return $this;
	}
}
