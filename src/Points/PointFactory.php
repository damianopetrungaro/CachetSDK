<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Points;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class PointFactory.
 *
 * The PointFactory generate a singleton for interact with Points in cachet
 */
class PointFactory
{
    /**
     * Build an object.
     *
     * @param $client
     *
     * @return object PointActions
     */
    public static function build(CachetClient $client)
    {
        return new PointActions($client);
    }
}
