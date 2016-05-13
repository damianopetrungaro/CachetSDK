<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\Exceptions package.
 *
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientException extends Exception
{
    public function __construct(RequestInterface $request, $message, \Exception $previous = null, ResponseInterface $response)
    {
        parent::__construct($request, $message, $previous, $response);
    }
}
