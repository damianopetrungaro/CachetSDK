<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\CachetClient;

class ClientFactory
{
    /**
     * Contains a right Client.
     *
     * @var null|CachetClient
     */
    public static $goodClient = null;

    /**
     * Contains a wrong Client.
     *
     * @var null|CachetClient
     */
    public static $badClient = null;

    /**
     * Define a new goodClient.
     *
     * @return CachetClient
     */
    public static function goodClient()
    {
        if (self::$goodClient == null) {
            self::$goodClient = new CachetClient('https://demo.cachethq.io/api/v1/', '9yMHsdioQosnyVK4iCVR');
        }

        return self::$goodClient;
    }

    /**
     * Define a new badClient.
     *
     * @return CachetClient
     */
    public static function badClient()
    {
        if (self::$badClient == null) {
            self::$badClient = new CachetClient('https://bad.endpoint.io/api/v1/', 'badToken');
        }

        return self::$badClient;
    }
}
