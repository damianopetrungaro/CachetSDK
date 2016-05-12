<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest\Unit;

use Damianopetrungaro\CachetSDK\General\GeneralFactory;
use Damianopetrungaro\CachetSDKTest\ClientFactory;

class GeneralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should return an array with data key as "Pong!".
     */
    public function testPingMethod()
    {
        $client = ClientFactory::goodClient();
        $generalFactory = GeneralFactory::build($client);
        $this->assertEquals($generalFactory->ping(), ['data' => 'Pong!']);
    }

    /**
     * Should return an array with data key as "2.3.0-dev".
     */
    public function testVersionMethod()
    {
        $client = ClientFactory::goodClient();
        $generalFactory = GeneralFactory::build($client);
        $this->assertEquals($generalFactory->version(), ['data' => '2.3.0-dev']);
    }
}
