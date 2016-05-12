<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Groups;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class GroupFactory.
 *
 * The GroupFactory generate a singleton for interact with Groups in cachet
 *
 * @package Damianopetrungaro\CachetSDK\Groups
 */
class GroupFactory
{
	/**
	 * Build an object
	 *
	 * @param $client
	 *
	 * @return object GroupActions
	 */
	public static function build(CachetClient $client)
	{
		return new GroupActions($client);
	}
}