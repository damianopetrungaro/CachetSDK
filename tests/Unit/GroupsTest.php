<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\Groups\GroupFactory;

class GroupsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should return a CachetSDKConnectException.
     *
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKConnectException
     */
    public function testFactoryReturnError()
    {
        $badClient = ClientFactory::badClient();
        $groupFactory = GroupFactory::build($badClient);
        $groupFactory->cacheGroups();
    }

    /**
     * Should create a new group.
     *
     * @param array $data
     *
     * @dataProvider rightStoreGroupArrayProvider
     */
    public function testStoreGroupReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $group = $groupFactory->storeGroup($data);
        $this->assertEquals($group['data']['name'], $data['name']);
    }

    /**
     * Should return a CachetSDKClientException.
     *
     * @param array $data
     *
     * @dataProvider wrongStoreGroupArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
     */
    public function testStoreGroupReturnError(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->storeGroup($data);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groups = $groupFactory->cacheGroups($num, $page);
        $this->assertArrayHasKey('data', $groups);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->cacheGroups($num, $page);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groups = $groupFactory->indexGroups($num, $page);
        $this->assertArrayHasKey('data', $groups);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->indexGroups($num, $page);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groups = $groupFactory->getGroup($id);
        $this->assertArrayHasKey('data', $groups);
    }

    /**
     * Should return a 404 data.
     *
     * @param mixed $id
     *
     * @dataProvider inexistentIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
     */
    public function testGetReturnEmpty($id)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->getGroup($id);
    }

    /**
     * Should return an CachetSDKServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testGetIDParamInvalid($id)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->getGroup($id);
    }

    /**
     * Should return an array with group data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $group = $groupFactory->searchGroups($search, $by);
        $this->assertArrayHasKey('id', $group);
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
        $groupFactory = GroupFactory::build($goodClient);
        $groups = $groupFactory->searchGroups($search, $by, true, 10);
        foreach ($groups as $group) {
            $this->assertArrayHasKey('id', $group);
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
        $groupFactory = GroupFactory::build($goodClient);
        $group = $groupFactory->searchGroups($search, $by);
        $this->assertEmpty($group);
    }

    /**
     * Should update a group.
     *
     * @param array $data
     *
     * @dataProvider rightUpdateGroupIDAndArrayProvider
     */
    public function testUpdateGroupReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $foundGroup = $groupFactory->searchGroups('-', 'name');
        $group = $groupFactory->updateGroup($foundGroup['id'], $data);
        $this->assertEquals($group['data']['name'], $data['name']);
        $this->assertEquals($group['data']['id'], $foundGroup['id']);
    }

    /**
     * Should return a CachetSDKServerException.
     *
     * @param mixed $id
     * @param array $data
     *
     * @dataProvider wrongUpdateGroupIDAndArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testUpdateGroupReturnError($id, array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->updateGroup($id, $data);
    }

    /**
     * Should delete a group.
     *
     * @param array $data
     *
     * @dataProvider rightStoreGroupArrayProvider
     */
    public function testDeleteGroupReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $created = $groupFactory->storeGroup($data);
        $group = $groupFactory->deleteGroup($created['data']['id']);
        $this->assertEmpty($group);
    }

    /**
     * Should return a CachetSDKServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongDeleteGroupIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testDeleteGroupReturnError($id)
    {
        $goodClient = ClientFactory::goodClient();
        $groupFactory = GroupFactory::build($goodClient);
        $groupFactory->deleteGroup($id);
    }

    /**
     * Return a set of right data for create a group.
     *
     * @return array
     */
    public function rightStoreGroupArrayProvider()
    {
        return [
            [[
                'name' => 'one-name',
                'order' => 1,
                'collapsed' => 1,
            ]],
            [[
                'name' => 'two-name',
                'order' => 1,
                'collapsed' => 1,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for create a group.
     *
     * @return array
     */
    public function wrongStoreGroupArrayProvider()
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
     * Return a set of right id for get a group.
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
     * Return a set of wrong id for get a group.
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
     * Return a set of inexistent id for get a group.
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
     * Return a set of right data for search a group.
     *
     * @return array
     */
    public function rightSearchParamsProvider()
    {
        return [
            ['-', 'name'],
            ['1', 'order'],
            ['1', 'collapsed'],
        ];
    }

    /**
     * Return a set of wrong data for search a group.
     *
     * @return array
     */
    public function inexistentSearchParamsProvider()
    {
        return [
            ['Inexistent', 'name'],
            ['wrong!', 'collapsed'],
            ['foo', 'wrong'],
            ['bar', ''],
        ];
    }

    /**
     * Return a set of right data for update a group.
     *
     * @return array
     */
    public function rightUpdateGroupIDAndArrayProvider()
    {
        return [
            [[
                'name' => 'new-one-name',
                'order' => 1,
                'collapsed' => 1,
            ]],
            [[
                'name' => 'new-two-name',
                'order' => 1,
                'collapsed' => 1,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for update a group.
     *
     * @return array
     */
    public function wrongUpdateGroupIDAndArrayProvider()
    {
        return [
            ['string!', ['status' => '']],
            [11212121212, ['name' => 'no data!']],
        ];
    }

    /**
     * Return a set of right data for delete a group.
     *
     * @return array
     */
    public function wrongDeleteGroupIDProvider()
    {
        return [
            ['string!'],
            [11212121212],
        ];
    }
}
