<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Subscribers;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class SubscriberFactory.
 *
 * The SubscriberFactory generate a singleton for interact with Subscribers in cachet
 */
class SubscriberFactory
{
    /**
     * Build an object.
     *
     * @param $client
     *
     * @return object SubscriberActions
     */
    public static function build(CachetClient $client)
    {
        return new SubscriberActions($client);
    }
}
