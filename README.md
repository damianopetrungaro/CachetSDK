#CachetSDK
A PHP SDK for [Cachet](https://cachethq.io/), providing a full functionality access.

## Click [here for the API Documentation of SDK](cachetsdk.damianopetrungaro.com)

#### Available Elements and method

* [General](#general)
    * [ping](#general-ping)
    * [version](#general-version)
* [Components](#components)
    * [cacheComponents](#components-cache)
    * [deleteComponent](#components-delete)
    * [getComponent](#components-get)
    * [indexComponents](#components-index)
    * [searchComponent](#components-search)
    * [storeComponent](#components-store)
    * [updateComponent](#components-update)
* [Groups](#groups)
    * [cacheGroups](#groups-cache)
    * [deleteGroup](#groups-delete)
    * [getGroup](#groups-get)
    * [indexGroups](#groups-index)
    * [searchGroup](#groups-search)
    * [storeGroup](#groups-store)
    * [updateGroup](#groups-update)
* [Incidents](#incidents)
    * [cacheIncidents](#incidents-cache)
    * [deleteIncident](#incidents-delete)
    * [getIncident](#incidents-get)
    * [indexIncidents](#incidents-index)
    * [searchIncident](#incidents-search)
    * [storeIncident](#incidents-store)
    * [updateIncident](#incidents-update)
* [Metrics](#metrics)
    * [cacheMetrics](#metrics-cache)
    * [deleteMetric](#metrics-delete)
    * [getMetric](#metrics-get)
    * [indexMetrics](#metrics-index)
    * [searchMetric](#metrics-search)
    * [storeMetric](#metrics-store)
* [Points](#points)
    * [cachePoints](#points-cache)
    * [deletePoint](#points-delete)
    * [indexPoints](#points-index)
    * [searchPoint](#points-search)
    * [storePoint](#points-store)
* [Subscribers](#subscribers)
    * [cacheSubscribers](#subscribers-cache)
    * [deleteSubscriber](#subscribers-delete)
    * [indexSubscribers](#subscribers-index)
    * [searchSubscriber](#subscribers-search)
    * [storeSubscriber](#subscribers-store)

## Cachet Client
For create a cachet client you need an endpoint and a token, those data are available on your Cachet site.

    $cachetClient = new CachetClient('endPointGoesHere/api/v1', 'tokenGoesHere');

A client MUST be injected to a ElementFactory. This allow you to use multiple sites of cachet in one shot!

All the factories are documented in the first part of each element.


## General

### Init a general element
For use one or more action for the General element, you must init an instance of GeneralActions.

```php
    $generalManager = GeneralFactory::build($cachetClient);
```


----------


### General Ping
This method ping your cachet site.

```php
    $generalManager = GeneralFactory::build($cachetClient);
    $pong = $generalManager->ping();
```

----------


### General Version

This method get your cachet site version.

```php
    $generalManager = GeneralFactory::build($cachetClient);
    $version = $generalManager->version();
```

----------
----------
----------

## Components

### Init a component element
For use one or more action for the Component element, you must init an instance of ComponentsActions.

```php
    $componentManager = ComponentFactory::build($cachetClient);
```

----------


### Components Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexComponents](#components-index) and [searchComponent](#components-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $cachedComponents = $componentManager->cacheComponents($num, $page)
```

###### $num (int - default = 1000) = Number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Components Delete

The delete method allows you to delete a specific component from cachet.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $deleteComponent = $componentManager->deleteComponent($id);
```

###### $id (int) = Component ID.


----------


### Components Get

The get method allows you to get a specific component from cachet.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $getComponent = $componentManager->getComponent($id);
```

###### $id (int) = Component ID.


----------


### Components Index

The index method allows you to get a list of component from cachet.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $indexComponents = $componentManager->indexComponents($num, $page, $cache)
```

###### $num (int - default = 1000) = Number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Components Search

The search method allows you to get one or more component from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $components = $componentManager->searchComponents($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of components to return.

###### $num (int - default = 1000) = Number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Components Store

The store method allows you to add a component.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $component = $componentManager->storeComponent($component)
```

###### $component (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
        'name' => 'component name',
        'description' => 'component description',
        'link' => 'component link',
        'status' => 1,
        'order' => 1,
        'group_id' => 0,
        'enabled' => 1,
    ];


----------


### Components Update


The update method allows you to update a specific component.

```php
    $componentManager = ComponentFactory::build($cachetClient);
    $component = $componentManager->updateComponent($id, $component)
```

###### $id (int) = Component ID.
###### $component (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
        'name' => 'component name',
        'description' => 'component description',
        'link' => 'component link',
        'status' => 1,
        'order' => 1,
        'group_id' => 0,
        'enabled' => 1,
    ];

----------
----------
----------

## Groups

### Init a group element
For use one or more action for the Group element, you must init an instance of GroupsActions.

```php
    $groupManager = GroupFactory::build($cachetClient);
```

----------


### Groups Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexGroups](#groups-index) and [searchGroup](#groups-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $cachedGroups = $groupManager->cacheGroups($num, $page)
```

###### $num (int - default = 1000) = Number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Groups Delete

The delete method allows you to delete a specific group from cachet.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $deleteGroup = $groupManager->deleteGroup($id);
```

###### $id (int) = Group ID.


----------


### Groups Get

The get method allows you to get a specific group from cachet.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $getGroup = $groupManager->getGroup($id);
```

###### $id (int) = Group ID.


----------


### Groups Index

The index method allows you to get a list of group from cachet.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $indexGroups = $groupManager->indexGroups($num, $page, $cache)
```

###### $num (int - default = 1000) = Number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Groups Search

The search method allows you to get one or more group from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $groupManager = GroupFactory::build($cachetClient);
    $groups = $groupManager->searchGroups($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of groups to return.

###### $num (int - default = 1000) = Number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Groups Store

The store method allows you to add a group.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $group = $groupManager->storeGroup($group)
```

###### $group (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'new group name',
      'order' => 1,
      'collapsed' => 0,
    ];


----------


### Groups Update


The update method allows you to update a specific group.

```php
    $groupManager = GroupFactory::build($cachetClient);
    $group = $groupManager->updateGroup($id, $group)
```

###### $id (int) = Group ID.
###### $group (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'new group name',
      'order' => 1,
      'collapsed' => 0,
    ];

----------
----------
----------


## Incidents

### Init a incident element
For use one or more action for the Incident element, you must init an instance of IncidentsActions.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
```

----------


### Incidents Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexIncidents](#incidents-index) and [searchIncident](#incidents-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $cachedIncidents = $incidentManager->cacheIncidents($num, $page)
```

###### $num (int - default = 1000) = Number of incident to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Incidents Delete

The delete method allows you to delete a specific incident from cachet.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $deleteIncident = $incidentManager->deleteIncident($id);
```

###### $id (int) = Incident ID.


----------


### Incidents Get

The get method allows you to get a specific incident from cachet.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $getIncident = $incidentManager->getIncident($id);
```

###### $id (int) = Incident ID.


----------


### Incidents Index

The index method allows you to get a list of incident from cachet.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $indexIncidents = $incidentManager->indexIncidents($num, $page, $cache)
```

###### $num (int - default = 1000) = Number of incident to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Incidents Search

The search method allows you to get one or more incident from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $incidents = $incidentManager->searchIncidents($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of incidents to return.

###### $num (int - default = 1000) = Number of incident to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Incidents Store

The store method allows you to add a incident.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $incident = $incidentManager->storeIncident($incident)
```

###### $incident (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'incident name',
      'message' => 'incident message',
      'status' => 1,
      'visible' => 1,
      'component_id' => 1,
      'component_status' => 1,
      'notify' => 1
    ];


----------


### Incidents Update


The update method allows you to update a specific incident.

```php
    $incidentManager = IncidentFactory::build($cachetClient);
    $incident = $incidentManager->updateIncident($id, $incident)
```

###### $id (int) = Incident ID.
###### $incident (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'incident name',
      'message' => 'incident message',
      'status' => 1,
      'visible' => 1,
      'component_id' => 1,
      'component_status' => 1,
      'notify' => 1
    ];

----------
----------
----------

## Metrics

### Init a metric element
For use one or more action for the Metric element, you must init an instance of MetricsActions.

```php
    $metricManager = MetricFactory::build($cachetClient);
```

----------


### Metrics Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexMetrics](#metrics-index) and [searchMetric](#metrics-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $metricManager = MetricFactory::build($cachetClient);
    $cachedMetrics = $metricManager->cacheMetrics($num, $page)
```

###### $num (int - default = 1000) = Number of metric to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Metrics Delete

The delete method allows you to delete a specific metric from cachet.

```php
    $metricManager = MetricFactory::build($cachetClient);
    $deleteMetric = $metricManager->deleteMetric($id);
```

###### $id (int) = Metric ID.


----------


### Metrics Get

The get method allows you to get a specific metric from cachet.

```php
    $metricManager = MetricFactory::build($cachetClient);
    $getMetric = $metricManager->getMetric($id);
```

###### $id (int) = Metric ID.


----------


### Metrics Index

The index method allows you to get a list of metric from cachet.

```php
    $metricManager = MetricFactory::build($cachetClient);
    $indexMetrics = $metricManager->indexMetrics($num, $page, $cache)
```

###### $num (int - default = 1000) = Number of metric to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Metrics Search

The search method allows you to get one or more metric from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $metricManager = MetricFactory::build($cachetClient);
    $metrics = $metricManager->searchMetrics($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of metrics to return.

###### $num (int - default = 1000) = Number of metric to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Metrics Store

The store method allows you to add a metric.

```php
    $metricManager = MetricFactory::build($cachetClient);
    $metric = $metricManager->storeMetric($metric)
```

###### $metric (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'metric name',
      'suffix' => 'metric suffix',
      'description' => 'metric description',
      'default_value' => 100,
      'display_chart' => 1,
      'calc_type' => 1,
      'default_view' => 1,
      'threshold' => 1,
    ];


----------
----------
----------


## Subscribers

### Init a subscriber element
For use one or more action for the Subscriber element, you must init an instance of SubscribersActions.

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
```

----------


### Subscribers Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexSubscribers](#subscribers-index) and [searchSubscriber](#subscribers-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
    $cachedSubscribers = $subscriberManager->cacheSubscribers($num, $page)
```

###### $num (int - default = 1000) = Number of subscriber to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Subscribers Delete

The delete method allows you to delete a specific subscriber from cachet.

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
    $deleteSubscriber = $subscriberManager->deleteSubscriber($id);
```

###### $id (int) = Subscriber ID.


----------


### Subscribers Index

The index method allows you to get a list of subscriber from cachet.

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
    $indexSubscribers = $subscriberManager->indexSubscribers($num, $page, $cache)
```

###### $num (int - default = 1000) = Number of subscriber to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Subscribers Search

The search method allows you to get one or more subscriber from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
    $subscribers = $subscriberManager->searchSubscribers($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of subscribers to return.

###### $num (int - default = 1000) = Number of subscriber to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Subscribers Store

The store method allows you to add a subscriber.

```php
    $subscriberManager = SubscriberFactory::build($cachetClient);
    $subscriber = $subscriberManager->storeSubscriber($subscriber)
```

###### $subscriber (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'name' => 'subscriber name',
      'suffix' => 'subscriber suffix',
      'description' => 'subscriber description',
      'default_value' => 100,
      'display_chart' => 1,
      'calc_type' => 1,
      'default_view' => 1,
      'threshold' => 1,
    ];

----------
----------
----------

## Points

### Init a point element
For use one or more action for the Point element, you must init an instance of PointsActions.

```php
    $pointManager = PointFactory::build($cachetClient);
```

----------


### Points Cache
The cache method allows you to call multiple time the API without kill the performance.
This method is used in [indexPoints](#points-index) and [searchPoint](#points-search), and use the cachet pagination.

Anyway you can instance it manually.

```php
    $pointManager = PointFactory::build($cachetClient);
    $cachedPoints = $pointManager->cachePoints($metricId, $num, $page)
```

###### $metricId (int) = Metric ID.

###### $num (int - default = 1000) = Number of point to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Points Delete

The delete method allows you to delete a specific point from cachet.

```php
    $pointManager = PointFactory::build($cachetClient);
    $deletePoint = $pointManager->deletePoint($metricId, $id);
```

###### $metricId (int) = Metric ID.

###### $id (int) = Point ID.


----------


### Points Index

The index method allows you to get a list of point from cachet.

```php
    $pointManager = PointFactory::build($cachetClient);
    $indexPoints = $pointManager->indexPoints($metricId, $num, $page, $cache)
```

###### $metricId (int) = Metric ID.

###### $num (int - default = 1000) = Number of point to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).

###### $cache (bool - default = true) = Use cache method.


----------


### Points Search

The search method allows you to get one or more point from cachet searching by key's value.

!!! THIS METHOD DON'T RETURN A STANDARD CACHET RESPONSE !!!
!!! RETURN A SIMPLE ARRAY WITH ALL THE FOUND COMPONENTS !!!

```php
    $pointManager = PointFactory::build($cachetClient);
    $points = $pointManager->searchPoints($metricId, $search, $by, $cache, $limit, $num, $page)
```

###### $metricId (int) = Metric ID.

###### $search (mixed) = Value to find.

###### $by (string) = Column where search the value.

###### $cache (bool - default = true) = Use cache method.

###### $limit (int - default = 1) = Number of points to return.

###### $num (int - default = 1000) = Number of point to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = Page number (uses cachet pagination).


----------


### Points Store

The store method allows you to add a point.

```php
    $pointManager = PointFactory::build($cachetClient);
    $point = $pointManager->storePoint($metricId, $point)
```

###### $metricId (int) = Metric ID.

###### $point (array) = For required params read the [Cachet Doc](https://docs.cachethq.io/docs).

    $sampleArray = [
      'value' => 100
    ];

