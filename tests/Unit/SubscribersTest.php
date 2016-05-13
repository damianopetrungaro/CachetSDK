<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\Subscribers\SubscriberFactory;

class SubscribersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should return a CachetSDKConnectException.
     *
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKConnectException
     */
    public function testFactoryReturnError()
    {
        $badClient = ClientFactory::badClient();
        $subscriberFactory = SubscriberFactory::build($badClient);
        $subscriberFactory->cacheSubscribers();
    }

    /**
     * Should create a new subscriber.
     *
     * @param array $data
     *
     * @dataProvider rightStoreSubscriberArrayProvider
     */
    public function testStoreSubscriberReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriber = $subscriberFactory->storeSubscriber($data);
        $this->assertEquals($subscriber['data']['name'], $data['name']);
    }

    /**
     * Should return a CachetSDKClientException.
     *
     * @param array $data
     *
     * @dataProvider wrongStoreSubscriberArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
     */
    public function testStoreSubscriberReturnError(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriberFactory->storeSubscriber($data);
    }

    /**
     * Should return an array with a 'data' key.
     *
     * @param int|null $num
     * @param int|null $page
     *
     * @dataProvider rightNumAndPageProvider
     */
    public function testCacheReturnData($num, $page)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscribers = $subscriberFactory->cacheSubscribers($num, $page);
        $this->assertArrayHasKey('data', $subscribers);
    }

    /**
     * Should return an CachetSDKServerException.
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
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriberFactory->cacheSubscribers($num, $page);
    }

    /**
     * Should return an array with a 'data' key.
     *
     * @param int|null $num
     * @param int|null $page
     *
     * @dataProvider rightNumAndPageProvider
     */
    public function testIndexReturnData($num, $page)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscribers = $subscriberFactory->indexSubscribers($num, $page);
        $this->assertArrayHasKey('data', $subscribers);
    }

    /**
     * Should return an CachetSDKServerException.
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
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriberFactory->indexSubscribers($num, $page);
    }

    /**
     * Should return an array with subscriber data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriber = $subscriberFactory->searchSubscribers($search, $by);
        $this->assertArrayHasKey('id', $subscriber);
    }

    /**
     * Should return an array with multiple subscriber data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnMultipleData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscribers = $subscriberFactory->searchSubscribers($search, $by, true, 10);
        foreach ($subscribers as $subscriber) {
            $this->assertArrayHasKey('id', $subscriber);
        }
    }

    /**
     * Should return an empty array.
     *
     * @param mixed $search
     * @param mixed $by
     *
     * @dataProvider inexistentSearchParamsProvider
     */
    public function testSearchReturnEmpty($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriber = $subscriberFactory->searchSubscribers($search, $by);
        $this->assertEmpty($subscriber);
    }

    /**
     * Should delete a subscriber.
     *
     * @param array $data
     *
     * @dataProvider rightStoreSubscriberArrayProvider
     */
    public function testDeleteSubscriberReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $created = $subscriberFactory->storeSubscriber($data);
        $subscriber = $subscriberFactory->deleteSubscriber($created['data']['id']);
        $this->assertEmpty($subscriber);
    }

    /**
     * Should return a CachetSDKServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongDeleteSubscriberIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testDeleteSubscriberReturnError($id)
    {
        $goodClient = ClientFactory::goodClient();
        $subscriberFactory = SubscriberFactory::build($goodClient);
        $subscriberFactory->deleteSubscriber($id);
    }

    /**
     * Return a set of right data for create a subscriber.
     *
     * @return array
     */
    public function rightStoreSubscriberArrayProvider()
    {
        return [
            [[
                'email' => 'mario@rossi.com',
                'verify' => 1,
            ]],
            [[
                'email' => 'luigi@verdi.com',
                'verify' => 0,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for create a subscriber.
     *
     * @return array
     */
    public function wrongStoreSubscriberArrayProvider()
    {
        return [
            [[
                'email' => '',
            ]],
            [[
                'email' => null,
            ]],
        ];
    }

    /**
     * Return a set of wrong parameters for cache.
     *
     * @return array
     */
    public function wrongNumAndPageProvider()
    {
        return [
            ['string', 'another string'],
            ['string', ''],
        ];
    }

    /**
     * Return a set of right parameters for cache.
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
            [2, ''],
        ];
    }

    /**
     * Return a set of right data for search a subscriber.
     *
     * @return array
     */
    public function rightSearchParamsProvider()
    {
        return [
            ['rossi', 'email'],
            ['verdi', 'email'],
        ];
    }

    /**
     * Return a set of wrong data for search a subscriber.
     *
     * @return array
     */
    public function inexistentSearchParamsProvider()
    {
        return [
            ['Inexistent', 'email'],
            ['wrong!', 'collapsed'],
            ['foo', 'verify'],
            ['bar', ''],
        ];
    }

    /**
     * Return a set of right data for delete a subscriber.
     *
     * @return array
     */
    public function wrongDeleteSubscriberIDProvider()
    {
        return [
            ['string!'],
            [11212121212],
        ];
    }
}
