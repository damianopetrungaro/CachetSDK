<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\General package.
 *
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\General;

use Damianopetrungaro\CachetSDK\CachetClient;

class GeneralActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * GroupActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    public function ping()
    {
        return $this->client->call('GET', 'ping');
    }

    public function version()
    {
        return $this->client->call('GET', 'version');
    }
}
