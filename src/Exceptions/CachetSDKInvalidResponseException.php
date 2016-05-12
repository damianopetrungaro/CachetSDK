<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\Exceptions package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CachetSDKInvalidResponseException extends CachetSDKException
{
    public function __construct(RequestInterface $request, ResponseInterface $response, \Exception $previous = null)
    {
        parent::__construct($request, 'The data format received is invalid. "data" key is missing from the response array', $previous, $response);
    }
}
