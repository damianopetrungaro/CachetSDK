<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Components;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class ComponentActions.
 *
 * The ComponentActions contains all the action for Components API available in CachetHQ
 */
class ComponentActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Components.
     *
     * @var null
     */
    protected $cached = null;

    /**
     * ComponentActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Cache Components for performance improvement.
     *
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cacheComponents($num = 1000, $page = 1)
    {
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            'components',
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
     * Get a defined number of Components.
     *
     * @param int  $num
     * @param int  $page
     * @param bool $cache
     *
     * @return array|bool
     */
    public function indexComponents($num = 1000, $page = 1, $cache = false)
    {
        if ($cache != false) {
            return $this->cacheComponents($num, $page);
        }

        return $this->client->call(
            'GET',
            'components',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Get a specific Component.
     *
     * @param int $id
     *
     * @return bool
     */
    public function getComponent($id)
    {
        return $this->client->call('GET', "components/$id");
    }

    /**
     * Search if a defined number of Components exists.
     *
     * @param string $search
     * @param string $by
     * @param bool   $cache
     * @param int    $num
     * @param int    $page
     * @param int    $limit
     *
     * @return mixed
     */
    public function searchComponents($search, $by, $cache = false, $limit = 1, $num = 1000, $page = 1)
    {
        $components = $this->indexComponents($num, $page, $cache)['data'];

        $filtered = array_filter(
            $components,
            function ($component) use ($search, $by) {

                if (array_key_exists($by, $component)) {
                    if (strpos($component[$by], $search) !== false) {
                        return $component;
                    }
                    if ($component[$by] === $search) {
                        return $component;
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
     * Store a Component.
     *
     * @param array $component
     *
     * @return bool
     */
    public function storeComponent(array $component)
    {
        return $this->client->call('POST', 'components', ['json' => $component]);
    }

    /**
     * Update a specific Component.
     *
     * @param int   $id
     * @param array $component
     *
     * @return bool
     */
    public function updateComponent($id, array $component)
    {
        return $this->client->call('PUT', "components/$id", ['json' => $component]);
    }

    /**
     * Delete a specific Component.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteComponent($id)
    {
        return $this->client->call('DELETE', "components/$id");
    }
}
