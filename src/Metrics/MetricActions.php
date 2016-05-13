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
     * MetricActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Set the cache to true or false
     *
     * @param bool $status
     */
    public function setCache($status)
    {
        $this->cache = $status;
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
     * @param int  $num
     * @param int  $page
     *
     * @return array|bool
     */
    public function indexMetrics($num = 1000, $page = 1)
    {
        if ($this->cache != false) {
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
     * @param int $metricId
     *
     * @return bool
     */
    public function getMetric($metricId)
    {
        return $this->client->call('GET', "metrics/$metricId");
    }

    /**
     * Search if a defined number of Metrics exists.
     *
     * @param string $search
     * @param string $by
     * @param int    $num
     * @param int    $page
     * @param int    $limit
     *
     * @return mixed
     */
    public function searchMetrics($search, $by, $limit = 1, $num = 1000, $page = 1)
    {
        $metrics = $this->indexMetrics($num, $page)['data'];

        $filtered = array_filter(
            $metrics,
            function ($metric) use ($search, $by) {

                if (array_key_exists($by, $metric)) {
                    if (strpos($metric[$by], $search) !== false) {
                        return $metric;
                    }
                    if ($metric[$by] === $search) {
                        return $metric;
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
     * Store a Metric.
     *
     * @param array $metric
     *
     * @return bool
     */
    public function storeMetric(array $metric)
    {
        return $this->client->call('POST', 'metrics', ['json' => $metric]);
    }

    /**
     * Update a specific Metric.
     *
     * @param int   $metricId
     * @param array $metric
     *
     * @return bool
     */
    public function updateMetric($metricId, array $metric)
    {
        return $this->client->call('PUT', "metrics/$metricId", ['json' => $metric]);
    }

    /**
     * Delete a specific Metric.
     *
     * @param int $metricId
     *
     * @return bool
     */
    public function deleteMetric($metricId)
    {
        return $this->client->call('DELETE', "metrics/$metricId");
    }
}
