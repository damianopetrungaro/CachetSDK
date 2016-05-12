<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\Metrics\MetricFactory;

class MetricsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Should return a CachetSDKConnectException
	 *
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKConnectException
	 */
	public function testFactoryReturnError()
	{
		$badClient = ClientFactory::badClient();
		$metricFactory = MetricFactory::build($badClient);
		$metricFactory->cacheMetrics();
	}

	/**
	 * Should create a new metric
	 *
	 * @param array $data
	 *
	 * @dataProvider rightStoreMetricArrayProvider
	 */
	public function testStoreMetricReturnData(array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metric = $metricFactory->storeMetric($data);
		$this->assertEquals($metric['data']['name'], $data['name']);
	}

	/**
	 * Should return a CachetSDKClientException
	 *
	 * @param array $data
	 *
	 * @dataProvider wrongStoreMetricArrayProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
	 */
	public function testStoreMetricReturnError(array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->storeMetric($data);
	}

	/**
	 * Should return an array with a 'data' key
	 *
	 * @param int|null $num
	 * @param int|null $page
	 *
	 * @dataProvider rightNumAndPageProvider
	 */
	public function testCacheReturnData($num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metrics = $metricFactory->cacheMetrics($num, $page);
		$this->assertArrayHasKey('data', $metrics);
	}

	/**
	 * Should return an CachetSDKServerException
	 *
	 * @param mixed $num
	 * @param mixed $page
	 *
	 * @dataProvider wrongNumAndPageProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testCacheNumOrPageParamsInvalid($num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->cacheMetrics($num, $page);
	}

	/**
	 * Should return an array with a 'data' key
	 *
	 * @param int|null $num
	 * @param int|null $page
	 *
	 * @dataProvider rightNumAndPageProvider
	 */
	public function testIndexReturnData($num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metrics = $metricFactory->indexMetrics($num, $page);
		$this->assertArrayHasKey('data', $metrics);
	}

	/**
	 * Should return an CachetSDKServerException
	 *
	 * @param mixed $num
	 * @param mixed $page
	 *
	 * @dataProvider wrongNumAndPageProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testIndexNumOrPageParamsInvalid($num, $page)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->indexMetrics($num, $page);
	}

	/**
	 * Should return an array with a 'data' key
	 *
	 * @param int $id
	 *
	 * @dataProvider rightIDProvider
	 */
	public function testGetReturnData($id)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metrics = $metricFactory->getMetric($id);
		$this->assertArrayHasKey('data', $metrics);
	}

	/**
	 * Should return a 404 data
	 *
	 * @param mixed $id
	 *
	 * @dataProvider inexistentIDProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
	 */
	public function testGetReturnEmpty($id)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->getMetric($id);
	}

	/**
	 * Should return an CachetSDKServerException
	 *
	 * @param mixed $id
	 *
	 * @dataProvider wrongIDProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testGetIDParamInvalid($id)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->getMetric($id);
	}


	/**
	 * Should return an array with metric data
	 *
	 * @param string $search
	 * @param string $by
	 *
	 * @dataProvider rightSearchParamsProvider
	 */
	public function testSearchReturnData($search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metric = $metricFactory->searchMetrics($search, $by);
		$this->assertArrayHasKey('id', $metric);
	}

	/**
	 * Should return an array with multiple metric data
	 *
	 * @param string $search
	 * @param string $by
	 *
	 * @dataProvider rightSearchParamsProvider
	 */
	public function testSearchReturnMultipleData($search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metrics = $metricFactory->searchMetrics($search, $by, true, 10);
		foreach ($metrics as $metric) {
			$this->assertArrayHasKey('id', $metric);
		}
	}

	/**
	 * Should return an empty array
	 *
	 * @param mixed $search
	 * @param mixed $by
	 *
	 * @dataProvider inexistentSearchParamsProvider
	 */
	public function testSearchReturnEmpty($search, $by)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metric = $metricFactory->searchMetrics($search, $by);
		$this->assertEmpty($metric);
	}

	/**
	 * Should update a metric
	 *
	 * @param array $data
	 *
	 * @dataProvider rightUpdateMetricIDAndArrayProvider
	 */
	public function testUpdateMetricReturnData(array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$foundMetric = $metricFactory->searchMetrics('-', 'name');
		$metric = $metricFactory->updateMetric($foundMetric['id'], $data);
		$this->assertEquals($metric['data']['name'], $data['name']);
		$this->assertEquals($metric['data']['id'], $foundMetric['id']);
	}

	/**
	 * Should return a CachetSDKServerException
	 *
	 * @param mixed $id
	 * @param array $data
	 *
	 * @dataProvider wrongUpdateMetricIDAndArrayProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testUpdateMetricReturnError($id, array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->updateMetric($id, $data);
	}

	/**
	 * Should delete a metric
	 *
	 * @param array $data
	 *
	 * @dataProvider rightStoreMetricArrayProvider
	 */
	public function testDeleteMetricReturnData(array $data)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$created = $metricFactory->storeMetric($data);
		$metric = $metricFactory->deleteMetric($created['data']['id']);
		$this->assertEmpty($metric);
	}

	/**
	 * Should return a CachetSDKServerException
	 *
	 * @param mixed $id
	 *
	 * @dataProvider wrongDeleteMetricIDProvider
	 * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
	 */
	public function testDeleteMetricReturnError($id)
	{
		$goodClient = ClientFactory::goodClient();
		$metricFactory = MetricFactory::build($goodClient);
		$metricFactory->deleteMetric($id);
	}

	/**
	 * Return a set of right data for create a metric
	 *
	 * @return array
	 */
	public function rightStoreMetricArrayProvider()
	{
		return [
			[[
				'name' => 'one-name',
				'suffix' => 'one-suffix',
				'description' => 'one-description',
				'default_value' => 0,
				'display_chart' => 1,
				'calc_type' => 1,
				'default_view' => 1,
				'threshold' => 3,
			]],
			[[
				'name' => 'two-name',
				'suffix' => 'two-suffix',
				'description' => 'two-description',
				'default_value' => 1,
				'display_chart' => 0,
				'calc_type' => 2,
				'default_view' => 3,
				'threshold' => 7,
			]]
		];
	}

	/**
	 * Return a set of wrong data for create a metric
	 *
	 * @return array
	 */
	public function wrongStoreMetricArrayProvider()
	{
		return [
			[[
				'name' => '',
			]],
			[[
				'name' => null,
			]]
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
			['string', 'another string'],
			['string', '']
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
			[1, 1],
			[200, 10],
			['', ''],
			['', 1],
			[2, '']
		];
	}

	/**
	 * Return a set of right id for get a metric
	 *
	 * @return array
	 */
	public function rightIDProvider()
	{
		return [
			[1],
			[2],
			[3]
		];
	}

	/**
	 * Return a set of wrong id for get a metric
	 *
	 * @return array
	 */
	public function wrongIDProvider()
	{
		return [
			['asdsadas'],
			['op!']
		];
	}

	/**
	 * Return a set of inexistent id for get a metric
	 *
	 * @return array
	 */
	public function inexistentIDProvider()
	{
		return [
			[10000],
			[1241242]
		];
	}

	/**
	 * Return a set of right data for search a metric
	 *
	 * @return array
	 */
	public function rightSearchParamsProvider()
	{
		return [
			['-', 'name'],
			['suffix', 'suffix'],
			[1, 'calc_type']
		];
	}

	/**
	 * Return a set of wrong data for search a metric
	 *
	 * @return array
	 */
	public function inexistentSearchParamsProvider()
	{
		return [
			['Inexistent', 'name'],
			['wrong!', 'collapsed'],
			['foo', 'wrong'],
			['bar', '']
		];
	}

	/**
	 * Return a set of right data for update a metric
	 *
	 * @return array
	 */
	public function rightUpdateMetricIDAndArrayProvider()
	{
		return [
			[[
				'name' => 'new-one-name',
				'suffix' => 'new-one-suffix',
				'description' => 'new-one-description',
				'default_value' => 0,
				'display_chart' => 1,
				'calc_type' => 1,
				'default_view' => 1,
				'threshold' => 3,
			]],
			[[
				'name' => 'new-two-name',
				'suffix' => 'new-two-suffix',
				'description' => 'new-two-description',
				'default_value' => 1,
				'display_chart' => 0,
				'calc_type' => 2,
				'default_view' => 3,
				'threshold' => 7,
			]]
		];
	}

	/**
	 * Return a set of wrong data for update a metric
	 *
	 * @return array
	 */
	public function wrongUpdateMetricIDAndArrayProvider()
	{
		return [
			['string!', ['status' => '']],
			[11212121212, ['name' => 'no data!']]
		];
	}

	/**
	 * Return a set of right data for delete a metric
	 *
	 * @return array
	 */
	public function wrongDeleteMetricIDProvider()
	{
		return [
			['string!'],
			[11212121212],
		];
	}
}