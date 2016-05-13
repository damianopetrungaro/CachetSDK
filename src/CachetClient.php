<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK;

use Damianopetrungaro\CachetSDK\Exceptions\TooManyRedirectsException as CachetTooManyRedirectsException;
use Damianopetrungaro\CachetSDK\Exceptions\InvalidResponseException as CachetInvalidResponseException;
use Damianopetrungaro\CachetSDK\Exceptions\ConnectException as CachetConnectException;
use Damianopetrungaro\CachetSDK\Exceptions\ClientException as CachetClientException;
use Damianopetrungaro\CachetSDK\Exceptions\ServerException as CachetServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

/**
 * Class CachetClient.
 *
 * Is a Guzzle Client for manage the API interaction from your application to cachet.
 *
 * @author      Damiano Petrungaro <damianopetrungaro@gmail.it>
 */
class CachetClient
{
    protected $client;

    /**
     * Cachet Client Singleton.
     *
     * @param $endpoint
     * @param $token
     */
    public function __construct($endpoint, $token)
    {
        $this->client = new Client(
            [
                'base_uri' => $endpoint,
                'headers' => [
                    'Content-type' => 'application/json',
                    'X-Cachet-Token' => $token,
                ],
            ]
        );
    }

    public function call($method, $endpoint, array $params = [])
    {
        try {
            $request = new Request($method, $endpoint, ['http_errors' => false]);
            $response = $this->client->send($request, $params);
            $body = json_decode($response->getBody(), true);
        } catch (ConnectException $e) {
            throw new CachetConnectException($e->getRequest(), $e->getMessage(), $e->getPrevious());
        } catch (ServerException $e) {
            throw new CachetServerException($e->getRequest(), $e->getMessage(), $e->getPrevious(), $e->getResponse());
        } catch (ClientException $e) {
            throw new CachetClientException($e->getRequest(), $e->getMessage(), $e->getPrevious(), $e->getResponse());
        } catch (TooManyRedirectsException $e) {
            throw new CachetTooManyRedirectsException($e->getRequest(), $e->getMessage(), $e->getPrevious(), $e->getResponse());
        }

        if ((is_array($body) && !array_key_exists('data', $body)) && !empty($body)) {
            throw new CachetInvalidResponseException($request, $response);
        }

        return $body;
    }
}
