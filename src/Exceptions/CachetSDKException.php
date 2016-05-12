<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\Exceptions package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;


class CachetSDKException extends RuntimeException implements CachetSDKExceptionInterface
{
	private $request;
	private $response;

	public function __construct(RequestInterface $request, $message, \Exception $previous = null, ResponseInterface $response = null)
	{
		parent::__construct($message, 0, $previous);
		$this->request = $request;
		$this->response = $response;
	}

	public function request()
	{
		return $this->request;
	}

	public function response()
	{
		return $this->response;
	}
}