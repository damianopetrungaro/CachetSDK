<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\Exceptions package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\Exceptions;

use Psr\Http\Message\RequestInterface;

class CachetSDKConnectException extends CachetSDKException
{
	public function __construct(RequestInterface $request, $message, \Exception $previous = null)
	{
		parent::__construct($request, $message, $previous);
	}
}