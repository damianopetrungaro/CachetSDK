<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 *
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest\Unit;

use Damianopetrungaro\CachetSDK\Components\ComponentFactory;
use Damianopetrungaro\CachetSDKTest\ClientFactory;

class ComponentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should return a ConnectException.
     *
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ConnectException
     */
    public function testFactoryReturnError()
    {
        $badClient = ClientFactory::badClient();
        $componentFactory = ComponentFactory::build($badClient);
        $componentFactory->cacheComponents();
    }

    /**
     * Should create a new component.
     *
     * @param array $data
     *
     * @dataProvider rightStoreComponentArrayProvider
     */
    public function testStoreComponentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $component = $componentFactory->storeComponent($data);
        $this->assertEquals($component['data']['name'], $data['name']);
    }

    /**
     * Should return a ClientException.
     *
     * @param array $data
     *
     * @dataProvider wrongStoreComponentArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ClientException
     */
    public function testStoreComponentReturnError(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->storeComponent($data);
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
        $componentFactory = ComponentFactory::build($goodClient);
        $components = $componentFactory->cacheComponents($num, $page);
        $this->assertArrayHasKey('data', $components);
    }

    /**
     * Should return a ServerException.
     *
     * @param mixed $num
     * @param mixed $page
     *
     * @dataProvider wrongNumAndPageProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ServerException
     */
    public function testCacheNumOrPageParamsInvalid($num, $page)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->cacheComponents($num, $page);
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
        $componentFactory = ComponentFactory::build($goodClient);
        $components = $componentFactory->indexComponents($num, $page);
        $this->assertArrayHasKey('data', $components);
    }

    /**
     * Should return a ServerException.
     *
     * @param mixed $num
     * @param mixed $page
     *
     * @dataProvider wrongNumAndPageProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ServerException
     */
    public function testIndexNumOrPageParamsInvalid($num, $page)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->indexComponents($num, $page);
    }

    /**
     * Should return an array with a 'data' key.
     *
     * @param int $id
     *
     * @dataProvider rightIDProvider
     */
    public function testGetReturnData($id)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $components = $componentFactory->getComponent($id);
        $this->assertArrayHasKey('data', $components);
    }

    /**
     * Should return a 404 data.
     *
     * @param mixed $id
     *
     * @dataProvider inexistentIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ClientException
     */
    public function testGetReturnEmpty($id)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->getComponent($id);
    }

    /**
     * Should return a ServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ServerException
     */
    public function testGetIDParamInvalid($id)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->getComponent($id);
    }

    /**
     * Should return an array with component data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $component = $componentFactory->searchComponents($search, $by);
        $this->assertArrayHasKey('id', $component);
    }

    /**
     * Should return an array with multiple group data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnMultipleData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->setCache(true);
        $components = $componentFactory->searchComponents($search, $by, 10);
        foreach ($components as $component) {
            $this->assertArrayHasKey('id', $component);
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
        $componentFactory = ComponentFactory::build($goodClient);
        $component = $componentFactory->searchComponents($search, $by);
        $this->assertEmpty($component);
    }

    /**
     * Should update a component.
     *
     * @param array $data
     *
     * @dataProvider rightUpdateComponentIDAndArrayProvider
     */
    public function testUpdateComponentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $foundComponent = $componentFactory->searchComponents('-', 'name');
        $component = $componentFactory->updateComponent($foundComponent['id'], $data);
        $this->assertEquals($component['data']['name'], $data['name']);
        $this->assertEquals($component['data']['id'], $foundComponent['id']);
    }

    /**
     * Should return a ServerException.
     *
     * @param mixed $id
     * @param array $data
     *
     * @dataProvider wrongUpdateComponentIDAndArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ServerException
     */
    public function testUpdateComponentReturnError($id, array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->updateComponent($id, $data);
    }

    /**
     * Should delete a component.
     *
     * @param array $data
     *
     * @dataProvider rightStoreComponentArrayProvider
     */
    public function testDeleteComponentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $created = $componentFactory->storeComponent($data);
        $component = $componentFactory->deleteComponent($created['data']['id']);
        $this->assertEmpty($component);
    }

    /**
     * Should return a ServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongDeleteComponentIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\ServerException
     */
    public function testDeleteComponentReturnError($id)
    {
        $goodClient = ClientFactory::goodClient();
        $componentFactory = ComponentFactory::build($goodClient);
        $componentFactory->deleteComponent($id);
    }

    /**
     * Return a set of right data for create a component.
     *
     * @return array
     */
    public function rightStoreComponentArrayProvider()
    {
        return [
            [[
                'name' => 'one-name',
                'description' => 'one-description',
                'link' => 'http://www.google.com',
                'status' => 1,
                'order' => 1,
                'group_id' => 1,
                'enabled' => 1,
            ]],
            [[
                'name' => 'two-name',
                'description' => 'two-description',
                'link' => 'http://www.yahoo.com',
                'status' => 2,
                'order' => 1,
                'group_id' => 0,
                'enabled' => 1,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for create a component.
     *
     * @return array
     */
    public function wrongStoreComponentArrayProvider()
    {
        return [
            [[
                'name' => '',
            ]],
            [[
                'name' => null,
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
     * Return a set of right id for get a component.
     *
     * @return array
     */
    public function rightIDProvider()
    {
        return [
            [1],
            [2],
            [3],
        ];
    }

    /**
     * Return a set of wrong id for get a component.
     *
     * @return array
     */
    public function wrongIDProvider()
    {
        return [
            ['asdsadas'],
            ['op!'],
        ];
    }

    /**
     * Return a set of inexistent id for get a component.
     *
     * @return array
     */
    public function inexistentIDProvider()
    {
        return [
            [10000],
            [1241242],
        ];
    }

    /**
     * Return a set of right data for search a component.
     *
     * @return array
     */
    public function rightSearchParamsProvider()
    {
        return [
            ['-', 'name'],
            ['one', 'description'],
            [1, 'status'],
        ];
    }

    /**
     * Return a set of wrong data for search a component.
     *
     * @return array
     */
    public function inexistentSearchParamsProvider()
    {
        return [
            ['Inexistent', 'name'],
            ['wrong!', 'status'],
            ['foo', 'wrong'],
            ['bar', ''],
        ];
    }

    /**
     * Return a set of right data for update a component.
     *
     * @return array
     */
    public function rightUpdateComponentIDAndArrayProvider()
    {
        return [
            [[
                'name' => 'new-one-name',
                'description' => 'new-one-name',
                'link' => 'http://www.newgoogle.com',
                'status' => 1,
                'order' => 1,
                'group_id' => 1,
                'enabled' => 1,
            ]],
            [[
                'name' => 'new-two-name',
                'description' => 'new-two-description',
                'link' => 'http://www.newyahoo.com',
                'status' => 1,
                'order' => 1,
                'group_id' => 1,
                'enabled' => 1,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for update a component.
     *
     * @return array
     */
    public function wrongUpdateComponentIDAndArrayProvider()
    {
        return [
            ['string!', ['status' => '']],
            [11212121212, ['name' => 'no data!']],
        ];
    }

    /**
     * Return a set of right data for delete a component.
     *
     * @return array
     */
    public function wrongDeleteComponentIDProvider()
    {
        return [
            ['string!'],
            [11212121212],
        ];
    }
}
