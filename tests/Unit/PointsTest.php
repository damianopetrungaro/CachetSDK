<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\Points\PointFactory;

class PointsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Should return a CachetSDKConnectException
	 *
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKConnectException
	 */
	public function testFactoryReturnError()
	{
		$badClient = ClientFactory::badClient();
		$pointFactory = PointFactory::build($badClient);
		$pointFactory->cachePoints('');
	}

	/**
	 * Should create a new point
	 *
	 * @param $metricId
	 * @param array $data
	 *
	 * @dataProvider rightStorePointArrayProvider
	 */
	public function testStorePointReturnData($metricId, array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$point = $pointFactory->storePoint($metricId, $data);
		$this->assertEquals($point['data']['value'], $data['value']);
	}

	/**
	 * Should return a CachetSDKClientException
	 *
	 * @param $metricId
	 * @param array $data
	 *
	 * @dataProvider wrongStorePointArrayProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
	 */
	public function testStorePointReturnError($metricId, array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$pointFactory->storePoint($metricId, $data);
	}

	/**
	 * Should return an array with a 'data' key
	 *
	 * @param $metricId
	 * @param int|null $num
	 * @param int|null $page
	 *
	 * @dataProvider rightNumAndPageProvider
	 */
	public function testCacheReturnData($metricId, $num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$points = $pointFactory->cachePoints($metricId, $num, $page);
		$this->assertArrayHasKey('data', $points);
	}

	/**
	 * Should return an CachetSDKClientException
	 *
	 * @param $metricId
	 * @param mixed $num
	 * @param mixed $page
	 *
	 * @dataProvider wrongNumAndPageProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
	 */
	public function testCacheNumOrPageParamsInvalid($metricId, $num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$pointFactory->cachePoints($metricId, $num, $page);
	}

	/**
	 * Should return an array with a 'data' key
	 *
	 * @param $metricId
	 * @param int|null $num
	 * @param int|null $page
	 *
	 * @dataProvider rightNumAndPageProvider
	 */
	public function testIndexReturnData($metricId, $num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$points = $pointFactory->indexPoints($metricId, $num, $page);
		$this->assertArrayHasKey('data', $points);
	}

	/**
	 * Should return an CachetSDKClientException
	 *
	 * @param $metricId
	 * @param mixed $num
	 * @param mixed $page
	 *
	 * @dataProvider wrongNumAndPageProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
	 */
	public function testIndexNumOrPageParamsInvalid($metricId, $num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$pointFactory->indexPoints($metricId, $num, $page);
	}


	/**
	 * Should return an array with point data
	 *
	 * @param $metricId
	 * @param string $search
	 * @param string $by
	 *
	 * @dataProvider rightSearchParamsProvider
	 */
	public function testSearchReturnData($metricId, $search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$point = $pointFactory->searchPoints($metricId, $search, $by);
		$this->assertArrayHasKey('id', $point);
	}

	/**
	 * Should return an array with multiple point data
	 *
	 * @param $metricId
	 * @param string $search
	 * @param string $by
	 *
	 * @dataProvider rightSearchParamsProvider
	 */
	public function testSearchReturnMultipleData($metricId, $search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$points = $pointFactory->searchPoints($metricId, $search, $by, true, 10);
		foreach ($points as $point) {
			$this->assertArrayHasKey('id', $point);
		}
	}

	/**
	 * Should return an empty array
	 *
	 * @param $metricId
	 * @param mixed $search
	 * @param mixed $by
	 *
	 * @dataProvider inexistentSearchParamsProvider
	 */
	public function testSearchReturnEmpty($metricId, $search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$point = $pointFactory->searchPoints($metricId, $search, $by);
		$this->assertEmpty($point);
	}


	/**
	 * Should delete a point
	 *
	 * @param $metricId
	 * @param array $data
	 *
	 * @dataProvider rightStorePointArrayProvider
	 */
	public function testDeletePointReturnData($metricId, array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$created = $pointFactory->storePoint($metricId, $data);
		$point = $pointFactory->deletePoint($metricId, $created['data']['id']);
		$this->assertEmpty($point);
	}

	/**
	 * Should return a CachetSDKServerException
	 *
	 * @param $metricId
	 * @param mixed $id
	 *
	 * @dataProvider wrongDeletePointIDProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testDeletePointReturnError($metricId, $id)
	{
		$goodClient = ClientFactory::goodClient();
		$pointFactory = PointFactory::build($goodClient);
		$pointFactory->deletePoint($metricId, $id);
	}

	/**
	 * Return a set of right data for create a point
	 *
	 * @return array
	 */
	public function rightStorePointArrayProvider()
	{
		return [
			[1, ['value' => 14]],
			[1, ['value' => 0]]
		];
	}

	/**
	 * Return a set of wrong data for create a point
	 *
	 * @return array
	 */
	public function wrongStorePointArrayProvider()
	{
		return [
			[12, ['value' => '']],
			[1, ['value' => 'asdasd']]
		];
	}

	/**
	 * Return a set of wrong parameters for cache
	 *
	 * @return array
	 */
	public function wrongNumAndPageProvider()
	{
		return [
			[21, 'string', 'another string'],
			['', 'string', '']
		];
	}

	/**
	 * Return a set of right parameters for cache
	 *
	 * @return array
	 */
	public function rightNumAndPageProvider()
	{
		return [
			[1, 1, 1],
			[1, 200, 10],
			[1, '', ''],
			[1, '', 1],
			[1, 2, '']
		];
	}

	/**
	 * Return a set of right data for search a point
	 *
	 * @return array
	 */
	public function rightSearchParamsProvider()
	{
		return [
			[1, 14, 'value'],
			[1, 0, 'value']
		];
	}

	/**
	 * Return a set of wrong data for search a point
	 *
	 * @return array
	 */
	public function inexistentSearchParamsProvider()
	{
		return [
			[1, 'Inexistent', 'name'],
			[1, 7753, 'value'],
			[1, 123, 'calue'],
			[1, 'bar', '']
		];
	}

	/**
	 * Return a set of right data for delete a point
	 *
	 * @return array
	 */
	public function wrongDeletePointIDProvider()
	{
		return [
			[1, 'string!'],
			[1, 11212121212],
		];
	}
}