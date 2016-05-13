<?php
/**
 * This file is part of the CachetSDK package.
 *
 * @author  Damiano Petrungaro  <damianopetrungaro@gmail.com>
 */

namespace Damianopetrungaro\CachetSDK\Subscribers;

use Damianopetrungaro\CachetSDK\CachetClient;

/**
 * Class SubscriberActions.
 *
 * The SubscriberActions contains all the action for Subscribers API available in CachetHQ
 */
class SubscriberActions
{
    /**
     * Contains Cachet Client (using Guzzle).
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains cached Subscribers.
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
     * SubscriberActions constructor.
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
     * Cache Subscribers for performance improvement.
     *
     * @param int $num
     * @param int $page
     *
     * @return array|bool
     */
    public function cacheSubscribers($num = 1000, $page = 1)
    {
        if ($this->cached != null) {
            return $this->cached;
        }

        $this->cached = $this->client->call(
            'GET',
            'subscribers',
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
     * Get a defined number of Subscribers.
     *
     * @param int  $num
     * @param int  $page
     *
     * @return array|bool
     */
    public function indexSubscribers($num = 1000, $page = 1)
    {
        if ($this->cache != false) {
            return $this->cacheSubscribers($num, $page);
        }

        return $this->client->call(
            'GET',
            'subscribers',
            [
                'query' => [
                    'per_page' => $num,
                    'current_page' => $page,
                ],
            ]
        );
    }

    /**
     * Search if a defined number of Subscribers exists.
     *
     * @param string $search
     * @param string $by
     * @param int    $num
     * @param int    $page
     * @param int    $limit
     *
     * @return mixed
     */
    public function searchSubscribers($search, $by, $limit = 1, $num = 1000, $page = 1)
    {
        $subscribers = $this->indexSubscribers($num, $page)['data'];

        $filtered = array_filter(
            $subscribers,
            function ($subscriber) use ($search, $by) {

                if (array_key_exists($by, $subscriber)) {
                    if (strpos($subscriber[$by], $search) !== false) {
                        return $subscriber;
                    }
                    if ($subscriber[$by] === $search) {
                        return $subscriber;
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
     * Store a Subscriber.
     *
     * @param array $subscriber
     *
     * @return bool
     */
    public function storeSubscriber(array $subscriber)
    {
        return $this->client->call('POST', 'subscribers', ['json' => $subscriber]);
    }

    /**
     * Delete a specific Subscriber.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteSubscriber($id)
    {
        return $this->client->call('DELETE', "subscribers/$id");
    }
}
