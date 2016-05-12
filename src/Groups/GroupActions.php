<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Groups;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class GroupActions.
 *
 * The GroupActions contains all the action for Groups API available in CachetHQ
 */
class GroupActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Groups.
     *
     * @var null
     */
    protected $cached = null;

    /**
     * GroupActions constructor.
     *
     * @param CachetClient $client
     */
    public function __construct(CachetClient $client)
    {
        $this->client = $client;
    }

    /**
     * Cache Group for performance improvement.
     *
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cacheGroups($num = 1000, $page = 1)
    {
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            'components/groups',
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
     * Get a defined number of Groups.
     *
     * @param int $num
     * @param int $page
     * @param bool $cache
     *
     * @return array|bool
     */
    public function indexGroups($num = 1000, $page = 1, $cache = false)
    {
        if ($cache != false) {
            return $this->cacheGroups($num, $page);
        }

        return $this->client->call(
            'GET',
            'components/groups',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Get a specific Group.
     *
     * @param int $id
     *
     * @return bool
     */
    public function getGroup($id)
    {
        return $this->client->call('GET', "components/groups/$id");
    }

    /**
     * Search if a defined number of Groups exists.
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
    public function searchGroups($search, $by, $cache = false, $limit = 1, $num = 1000, $page = 1)
    {
        $groups = $this->indexGroups($num, $page, $cache)['data'];

        $filtered = array_filter(
            $groups,
            function ($group) use ($search, $by) {
                if (strpos($group[$by], $search) !== false) {
                    return $group;
                }
                if ($group[$by] === $search) {
                    return $group;
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
     * Store a Group.
     *
     * @param array $group
     *
     * @return bool
     */
    public function storeGroup(array $group)
    {
        return $this->client->call(
            'POST',
            'components/groups',
            [
                'json' => [
                    'name' => $group['name'],
                    'order' => $group['order'] ?: 0,
                    'collapsed' => $group['collapsed'] ?: 0,
                ],
            ]
        );
    }

    /**
     * Update a specific Group.
     *
     * @param int $id
     * @param array $group
     *
     * @return bool
     */
    public function updateGroup($id, array $group)
    {
        return $this->client->call(
            'PUT',
            "components/groups/$id",
            [
                'json' => [
                    'name' => $group['name'],
                    'order' => $group['order'],
                    'collapsed' => $group['collapsed'],
                ],
            ]
        );
    }

    /**
     * Delete a specific Group.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteGroup($id)
    {
        return $this->client->call('DELETE', "components/groups/$id");
    }
}
