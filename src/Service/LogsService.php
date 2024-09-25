<?php

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;

class LogsService
{
	private $repository;
	private $loggerInterface;

	public function __construct($repository, LoggerInterface $loggerInterface = null)
	{
		$this->repository = $repository;
		$this->loggerInterface = $loggerInterface;
	}

	public function pushLogs($class, $identifier, $request, $response, $url = null, $status = null)
	{
		try {
			$class->setidentifier($identifier);
			$class->seturl($url);
			$class->setrequest($request);
			$class->setresponse($response);
			$class->setresponseStatusCode($status);
			$this->repository->persist($class);
			$this->repository->flush();

			return true;
		} catch (Exception $e) {
			if ($this->loggerInterface) {
				$this->loggerInterface->info($e->getMessage());
			} else {
				// Handle the case when the logger is not initialized
				error_log('Logger not initialized!');
			}
			return false;
		}
	}
}
