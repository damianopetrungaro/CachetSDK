<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Components;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class ComponentFactory.
 *
 * The ComponentFactory generate a singleton for interact with Components in cachet
 */
class ComponentFactory
{
    /**
     * Build an object.
     *
     * @param $client
     *
     * @return object ComponentActions
     */
    public static function build(CachetClient $client)
    {
        return new ComponentActions($client);
    }
}
