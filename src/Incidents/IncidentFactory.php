<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Incidents;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class IncidentFactory.
 *
 * The IncidentFactory generate a singleton for interact with Incidents in cachet
 *
 * @package Damianopetrungaro\CachetSDK\Incidents
 */
class IncidentFactory
{
	/**
	 * Build an object
	 *
	 * @param $client
	 *
	 * @return object IncidentActions
	 */
	public static function build(CachetClient $client)
	{
		return new IncidentActions($client);
	}
}