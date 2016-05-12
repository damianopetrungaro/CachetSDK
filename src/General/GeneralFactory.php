<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK\General package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDK\General;


use Damianopetrungaro\CachetSDK\CachetClient;

class GeneralFactory
{
	/**
	 * Build an object
	 *
	 * @param $client
	 *
	 * @return object GeneralActions
	 */
	public static function build(CachetClient $client)
	{
		return new GeneralActions($client);
	}
}