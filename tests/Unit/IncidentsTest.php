<?php
/**
 * This file is part of the Damianopetrungaro\CachetSDK package.
 * @author Damiano Petrungaro <damianopetrungaro@gmail.it>
 */

namespace Damianopetrungaro\CachetSDKTest;

use Damianopetrungaro\CachetSDK\Incidents\IncidentFactory;

class IncidentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should return a CachetSDKConnectException.
     *
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKConnectException
     */
    public function testFactoryReturnError()
    {
        $badClient = ClientFactory::badClient();
        $incidentFactory = IncidentFactory::build($badClient);
        $incidentFactory->cacheIncidents();
    }

    /**
     * Should create a new incident.
     *
     * @param array $data
     *
     * @dataProvider rightStoreIncidentArrayProvider
     */
    public function testStoreIncidentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incident = $incidentFactory->storeIncident($data);
        $this->assertEquals($incident['data']['name'], $data['name']);
    }

    /**
     * Should return a CachetSDKClientException.
     *
     * @param array $data
     *
     * @dataProvider wrongStoreIncidentArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKClientException
     */
    public function testStoreIncidentReturnError(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->storeIncident($data);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidents = $incidentFactory->cacheIncidents($num, $page);
        $this->assertArrayHasKey('data', $incidents);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->cacheIncidents($num, $page);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidents = $incidentFactory->indexIncidents($num, $page);
        $this->assertArrayHasKey('data', $incidents);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->indexIncidents($num, $page);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidents = $incidentFactory->getIncident($id);
        $this->assertArrayHasKey('data', $incidents);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->getIncident($id);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->getIncident($id);
    }

    /**
     * Should return an array with incident data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incident = $incidentFactory->searchIncidents($search, $by);
        $this->assertArrayHasKey('id', $incident);
    }

    /**
     * Should return an array with multiple incident data.
     *
     * @param string $search
     * @param string $by
     *
     * @dataProvider rightSearchParamsProvider
     */
    public function testSearchReturnMultipleData($search, $by)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidents = $incidentFactory->searchIncidents($search, $by, true, 10);
        foreach ($incidents as $incident) {
            $this->assertArrayHasKey('id', $incident);
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
        $incidentFactory = IncidentFactory::build($goodClient);
        $incident = $incidentFactory->searchIncidents($search, $by);
        $this->assertEmpty($incident);
    }

    /**
     * Should update a incident.
     *
     * @param array $data
     *
     * @dataProvider rightUpdateIncidentIDAndArrayProvider
     */
    public function testUpdateIncidentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $foundIncident = $incidentFactory->searchIncidents('-', 'name');
        $incident = $incidentFactory->updateIncident($foundIncident['id'], $data);
        $this->assertEquals($incident['data']['name'], $data['name']);
        $this->assertEquals($incident['data']['id'], $foundIncident['id']);
    }

    /**
     * Should return a CachetSDKServerException.
     *
     * @param mixed $id
     * @param array $data
     *
     * @dataProvider wrongUpdateIncidentIDAndArrayProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testUpdateIncidentReturnError($id, array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->updateIncident($id, $data);
    }

    /**
     * Should delete a incident.
     *
     * @param array $data
     *
     * @dataProvider rightStoreIncidentArrayProvider
     */
    public function testDeleteIncidentReturnData(array $data)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $created = $incidentFactory->storeIncident($data);
        $incident = $incidentFactory->deleteIncident($created['data']['id']);
        $this->assertEmpty($incident);
    }

    /**
     * Should return a CachetSDKServerException.
     *
     * @param mixed $id
     *
     * @dataProvider wrongDeleteIncidentIDProvider
     * @expectedException \Damianopetrungaro\CachetSDK\Exceptions\CachetSDKServerException
     */
    public function testDeleteIncidentReturnError($id)
    {
        $goodClient = ClientFactory::goodClient();
        $incidentFactory = IncidentFactory::build($goodClient);
        $incidentFactory->deleteIncident($id);
    }

    /**
     * Return a set of right data for create a incident.
     *
     * @return array
     */
    public function rightStoreIncidentArrayProvider()
    {
        return [
            [[
                'name' => 'one-name',
                'message' => 'one-message',
                'status' => 2,
                'visible' => 1,
                'component_id' => 1,
                'component_status' => 1,
                'notify' => 1,
            ]],
            [[
                'name' => 'two-name',
                'message' => 'two-message',
                'status' => 3,
                'visible' => 0,
                'component_id' => 1,
                'component_status' => 3,
                'notify' => 0,
            ]],
        ];
    }

    /**
     * Return a set of wrong data for create a incident.
     *
     * @return array
     */
    public function wrongStoreIncidentArrayProvider()
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
     * Return a set of right id for get a incident.
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
     * Return a set of wrong id for get a incident.
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
     * Return a set of inexistent id for get a incident.
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
     * Return a set of right data for search a incident.
     *
     * @return array
     */
    public function rightSearchParamsProvider()
    {
        return [
            ['-', 'name'],
            ['one', 'message'],
            [1, 'visible'],
        ];
    }

    /**
     * Return a set of wrong data for search a incident.
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
     * Return a set of right data for update a incident.
     *
     * @return array
     */
    public function rightUpdateIncidentIDAndArrayProvider()
    {
        return [
            [[
                'name' => 'new-one-name',
                'message' => 'new-one-message',
                'status' => 2,
                'visible' => 1,
                'component_id' => 1,
                'component_status' => 1,
                'notify' => 1,
            ]],
            [[
                'name' => 'new-two-name',
                'message' => 'new-two-message',
                'status' => 3,
                'visible' => 0,
                'component_id' => 1,
                'component_status' => 3,
                'notify' => 0,
            ]],

        ];
    }

    /**
     * Return a set of wrong data for update a incident.
     *
     * @return array
     */
    public function wrongUpdateIncidentIDAndArrayProvider()
    {
        return [
            ['string!', ['status' => '']],
            [11212121212, ['name' => 'no data!']],
        ];
    }

    /**
     * Return a set of right data for delete a incident.
     *
     * @return array
     */
    public function wrongDeleteIncidentIDProvider()
    {
        return [
            ['string!'],
            [11212121212],
        ];
    }
}
