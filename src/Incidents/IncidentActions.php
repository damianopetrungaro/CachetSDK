<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Incidents;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class IncidentActions.
 *
 * The IncidentActions contains all the action for Incidents API available in CachetHQ
 */
class IncidentActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Incidents.
     *
     * @var null
     */
    protected $cached = null;

    /**
     * Cache status. If is true use cache.
     *
     * @var bool
     */
    private $cache = false;

    /**
     * IncidentActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Set the cache to true or false.
     *
     * @param bool $status
     */
    public function setCache($status)
    {
        $this->cache = $status;
    }

    /**
     * Cache Incidents for performance improvement.
     *
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cacheIncidents($num = 1000, $page = 1)
    {
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            'incidents',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );

        return $this->cached;
    }

    /**
     * Get a defined number of Incidents.
     *
     * @param int  $num
     * @param int  $page
     *
     * @return array|bool
     */
    public function indexIncidents($num = 1000, $page = 1)
    {
        if ($this->cache != false) {
            return $this->cacheIncidents($num, $page);
        }

        return $this->client->call(
            'GET',
            'incidents',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Get a specific Incident.
     *
     * @param int $incidentId
     *
     * @return bool
     */
    public function getIncident($incidentId)
    {
        return $this->client->call('GET', "incidents/$incidentId");
    }

    /**
     * Search if a defined number of Incidents exists.
     *
     * @param string $search
     * @param string $by
     * @param int    $num
     * @param int    $page
     * @param int    $limit
     *
     * @return mixed
     */
    public function searchIncidents($search, $by, $limit = 1, $num = 1000, $page = 1)
    {
        $incidents = $this->indexIncidents($num, $page)['data'];

        $filtered = array_filter(
            $incidents,
            function ($incident) use ($search, $by) {

                if (array_key_exists($by, $incident)) {
                    if (strpos($incident[$by], $search) !== false) {
                        return $incident;
                    }
                    if ($incident[$by] === $search) {
                        return $incident;
                    }
                }

                return false;
            }
        );

        if ($limit == 1) {
            return array_shift($filtered);
        }

        return array_slice($filtered, 0, $limit);
    }

    /**
     * Store a Incident.
     *
     * @param array $incident
     *
     * @return bool
     */
    public function storeIncident(array $incident)
    {
        return $this->client->call('POST', 'incidents', ['json' => $incident]);
    }

    /**
     * Update a specific Incident.
     *
     * @param int   $incidentId
     * @param array $incident
     *
     * @return bool
     */
    public function updateIncident($incidentId, array $incident)
    {
        return $this->client->call('PUT', "incidents/$incidentId", ['json' => $incident]);
    }

    /**
     * Delete a specific Incident.
     *
     * @param int $incidentId
     *
     * @return bool
     */
    public function deleteIncident($incidentId)
    {
        return $this->client->call('DELETE', "incidents/$incidentId");
    }
}
