<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Metrics;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class MetricFactory.
 *
 * The MetricFactory generate a singleton for interact with Metrics in cachet
 *
 * @package Damianopetrungaro\CachetSDK\Metrics
 */
class MetricFactory
{
	/**
	 * Build an object
	 *
	 * @param $client
	 *
	 * @return object MetricActions
	 */
	public static function build(CachetClient $client)
	{
		return new MetricActions($client);
	}
}