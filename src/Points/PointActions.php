<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Points;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class PointActions.
 *
 * The PointActions contains all the action for Points API available in CachetHQ
 */
class PointActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Points.
     *
     * @var null
     */
    protected $cached = null;

    /**
     * PointActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Cache Points for performance improvement.
     *
     * @param int $metricId
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cachePoints($metricId, $num = 1000, $page = 1)
    {
        // If cache already exists return it
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            "metrics/$metricId/points",
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
     * Get a defined number of Points.
     *
     * @param int $metricId
     * @param int $num
     * @param int $page
     * @param bool $cache
     *
     * @return array|bool
     */
    public function indexPoints($metricId, $num = 1000, $page = 1, $cache = false)
    {
        if ($cache != false) {
            return $this->cachePoints($metricId, $num, $page);
        }

        return $this->client->call(
            'GET',
            "metrics/$metricId/points",
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Search if a defined number of Points exists.
     *
     * @param $metricId
     * @param string $search
     * @param string $by
     * @param bool $cache
     * @param int $limit
     * @param int $num
     * @param int $page
     *
     * @return mixed
     */
    public function searchPoints($metricId, $search, $by, $cache = false, $limit = 1, $num = 1000, $page = 1)
    {
        $points = $this->indexPoints($metricId, $num, $page, $cache)['data'];

        $filtered = array_filter(
            $points,
            function ($point) use ($search, $by) {
                if (strpos($point[$by], $search) !== false) {
                    return $point;
                }
                if ($point[$by] === $search) {
                    return $point;
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
     * Store a Point.
     *
     * @param int $metricId
     * @param array $point
     *
     * @return bool
     */
    public function storePoint($metricId, array $point)
    {
        return $this->client->call(
            'POST',
            "metrics/$metricId/points",
            [
                'json' => [
                    'value' => $point['value'],
                ],
            ]
        );
    }

    /**
     * Delete a specific Point.
     *
     * @param $metricId
     * @param int $id
     *
     * @return bool
     */
    public function deletePoint($metricId, $id)
    {
        return $this->client->call('DELETE', "metrics/$metricId/points/$id");
    }
}
