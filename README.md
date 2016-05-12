#CachetSDK
A PHP SDK for [Cachet](https://cachethq.io/), providing a full functionality access.

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
* [Metrics](#metrics)
* [Points](#points)
* [Subscribers](#subscribers)

## Cachet Client
For create a cachet client you need an endpoint and a token, those data are available on your CachetHQ site.

    $cachetClient = new CachetClient('endPointGoesHere/api/v1', 'tokenGoesGere');

A client MUST be injected to a ElementFactory. This allow you to use multiple sites of cachet in one shot!

All the Factories are documented in the first part of each element.


## General

### Init a general element
For use one or more action for the general element, you must init an instance of GeneralActions.

```php
    $generalManager = GeneralFactory::build($cachetClient);
```


----------


### General Ping
This method simply ping your cachet site.

```php
    $generalManager = GeneralFactory::build($cachetClient);
    $pong = $generalManager->ping();
```

----------


### General Version

This method simply get your cachet site version.

```php
    $generalManager = GeneralFactory::build($cachetClient);
    $version = $generalManager->version();
```

----------
----------
----------

## Components

### Init a component element
For use one or more action for the component element, you must init an instance of ComponentsActions.

```php
    $componentManager = ComponentFactory::build($cachetClient);
```

----------


### Components Cache
The cache method allows you to use call multiple time the API without kill the performance.
This method is used in [indexComponents](#components-index) and [searchComponent](#components-search), and use the cachet pagination.

Anyway you can instance it manually.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $cachedComponents = $componentManager->cacheComponents($num, $page)
```

###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).


----------


### Components Delete

The delete method allows you to delete a specific component from cachet.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $deleteComponent = $componentManager->deleteComponent($id);
```
$id (int) = component ID.


----------


### Components Get

The get method allows you to get a specific component from cachet.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $getComponent = $componentManager->getComponent($id);
```
###### $id (int) = component ID.


----------


### Components Index

The index method allows you to get a list of component from cachet.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $indexComponents = $componentManager->indexComponents($num, $page, $cache)
```
###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).

###### $cache (bool - default = true) = prefer cached components


----------


### Components Search

The search method allows you to get one or more component from cachet searching by key's value.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $components = $componentManager->searchComponents($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = is the value to search for

###### $by (string) = is the column where search

###### $cache (bool - default = true) = prefer cached components

###### $limit (int - default = 1) = number of components to return

###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).


----------


### Components Store

The store method allows you to add a component.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $component = $componentManager->storeComponent($component)
```
###### $component (array) = Sample:

    [
        'name' => 'component name',
        'description' => 'component description is optional',
        'link' => 'component link is optional',
        'status' => 1, // Read Cachet doc for more info
        'order' => 1, // Read Cachet doc for more info
        'group_id' => 0, // Read Cachet doc for more info
        'enabled' => 1, // Read Cachet doc for more info
    ]


----------


### Components Update


The update method allows you to update a specific component.
```php
    $componentManager = ComponentFactory::build($cachetClient);
    $component = $componentManager->updateComponent($id, $component)
```
###### $id (int) = component ID
###### $component (array) = Sample:

    [
        'name' => 'new component name',
        'description' => 'new component description',
        'link' => 'new component link',
        'status' => 1, // Read Cachet doc for more info
        'order' => 1, // Read Cachet doc for more info
        'group_id' => 0, // Read Cachet doc for more info
        'enabled' => 1, // Read Cachet doc for more info
    ]

----------
----------
----------

## Groups

### Init a group element
For use one or more action for the group element, you must init an instance of GroupsActions.

```php
    $groupManager = GroupFactory::build($cachetClient);
```

----------


### Groups Cache
The cache method allows you to use call multiple time the API without kill the performance.
This method is used in [indexGroups](#groups-index) and [searchGroup](#groups-search), and use the cachet pagination.

Anyway you can instance it manually.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $cahedGroups = $groupManager->cacheGroups($num, $page)
```

###### $num (int - default = 1000) = is the number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).


----------


### Groups Delete

The delete method allows you to delete a specific group from cachet.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $deleteGroup = $groupManager->deleteGroup($id);
```
$id (int) = group ID.


----------


### Groups Get

The get method allows you to get a specific group from cachet.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $getGroup = $groupManager->getGroup($id);
```
###### $id (int) = group ID.


----------


### Groups Index

The index method allows you to get a list of group from cachet.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $indexGroups = $groupManager->indexGroups($num, $page, $cache)
```
###### $num (int - default = 1000) = is the number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).

###### $cache (bool - default = true) = prefer cached groups


----------


### Groups Search

The search method allows you to get one or more group from cachet searching by key's value.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $groups = $groupManager->searchGroups($search, $by, $cache, $limit, $num, $page)
```

###### $search (mixed) = is the value to search for

###### $by (string) = is the column where search

###### $cache (bool - default = true) = prefer cached groups

###### $limit (int - default = 1) = number of groups to return

###### $num (int - default = 1000) = is the number of group to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).


----------


### Groups Store

The store method allows you to add a group.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $group = $groupManager->storeGroup($group)
```
###### $group (array) = Sample:

    [
        'name' => 'group name',
        'order' => 1, // Read Cachet doc for more info
        'collapsed' => 0, // Read Cachet doc for more info
    ]


----------


### Groups Update


The update method allows you to update a  specific group.
```php
    $groupManager = GroupFactory::build($cachetClient);
    $group = $groupManager->updateGroup($id, $group)
```
###### $id (int) = group ID
###### $group (array) = Sample:

    [
        'name' => 'new group name',
        'order' => 1, // Read Cachet doc for more info
        'collapsed' => 0, // Read Cachet doc for more info
    ]

