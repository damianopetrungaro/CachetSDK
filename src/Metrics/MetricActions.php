<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Metrics;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class MetricActions.
 *
 * The MetricActions contains all the action for Metrics API available in CachetHQ
 */
class MetricActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Metrics.
     * @var null
     */
    protected $cached = null;

    /**
     * MetricActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Cache Metrics for performance improvement.
     *
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cacheMetrics($num = 1000, $page = 1)
    {
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            'metrics',
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
     * Get a defined number of Metrics.
     *
     * @param int $num
     * @param int $page
     * @param bool $cache
     *
     * @return array|bool
     */
    public function indexMetrics($num = 1000, $page = 1, $cache = false)
    {
        if ($cache != false) {
            return $this->cacheMetrics($num, $page);
        }

        return $this->client->call(
            'GET',
            'metrics',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Get a specific Metric.
     *
     * @param int $id
     *
     * @return bool
     */
    public function getMetric($id)
    {
        return $this->client->call('GET', "metrics/$id");
    }

    /**
     * Search if a defined number of Metrics exists.
     *
     * @param string $search
     * @param string $by
     * @param bool $cache
     * @param int $num
     * @param int $page
     * @param int $limit
     *
     * @return mixed
     */
    public function searchMetrics($search, $by, $cache = false, $limit = 1, $num = 1000, $page = 1)
    {
        $metrics = $this->indexMetrics($num, $page, $cache)['data'];

        $filtered = array_filter(
            $metrics,
            function ($metric) use ($search, $by) {
                if (strpos($metric[$by], $search) !== false) {
                    return $metric;
                }
                if ($metric[$by] === $search) {
                    return $metric;
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
     * Store a Metric.
     *
     * @param array $metric
     *
     * @return bool
     */
    public function storeMetric(array $metric)
    {
        return $this->client->call(
            'POST',
            'metrics',
            [
                'json' => [
                    'name' => $metric['name'],
                    'suffix' => $metric['suffix'],
                    'description' => $metric['description'],
                    'default_value' => $metric['default_value'] ?: 0,
                    'display_chart' => $metric['display_chart'] ?: true,
                    'calc_type' => $metric['calc_type'] ?: 1,
                    'default_view' => $metric['default_view'] ?: 0,
                    'threshold' => $metric['threshold'] ?: 1,
                ],
            ]
        );
    }

    /**
     * Update a specific Metric.
     *
     * @param int $id
     * @param array $metric
     *
     * @return bool
     */
    public function updateMetric($id, array $metric)
    {
        return $this->client->call(
            'PUT',
            "metrics/$id",
            [
                'json' => [
                    'name' => $metric['name'],
                    'suffix' => $metric['suffix'],
                    'description' => $metric['description'],
                    'default_value' => $metric['default_value'],
                    'display_chart' => $metric['display_chart'],
                    'calc_type' => $metric['calc_type'],
                    'default_view' => $metric['default_view'],
                    'threshold' => $metric['threshold'],
                ],
            ]
        );
    }

    /**
     * Delete a specific Metric.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteMetric($id)
    {
        return $this->client->call('DELETE', "metrics/$id");
    }
}
