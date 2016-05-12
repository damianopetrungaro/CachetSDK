#CachetSDK
A PHP SDK for [Cachet](https://cachethq.io/), providing a full functionality access.

#### Avaiable Elements and method

* [Components](#components)
    * [cacheComponents](#components-cache)
    * [deleteComponent](#components-delete)
    * [getComponent](#components-get)
    * [indexComponents](#components-index)
    * [searchComponent](#components-search)
    * [storeComponent](#components-store)
    * [updateComponent](#components-update)
* [Groups](#groups)
* [Incidents](#incidents)
* [Metrics](#metrics)
* [Points](#points)
* [Subscribers](#subscribers)

## Cachet Client
For create a cachet client you need an enpoint and a token, those data are avaiable on your CachetHQ site.

    $cachetClient = new CachetClient('endPointGoesHere/api/v1', 'tokenGoesGere');
    
A client MUST be injected to a ElementFactory. This allow you tu use multiple sites of cachet in one shot!

All the Factories are documented in the first part of each element.

## Components

### Init a component
For use one or more action for the component element, you must init an insstance of ComponentsActions.

    $componentManager = ComponentFactory::build($cachetClient);
    
### Components Cache
The cache method allows you to use call multiple time the API without kill the perfrormance.
This method is used in [indexComponents](#components-index) and [searchComponent](#components-search), and use the cachet pagination.

Anyway you can instance it manually.

    $componentManager = ComponentFactory::build($cachetClient);
    $cahedComponents = $componentManager->cacheComponents($num, $page)


###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).


### Components Delete

The delete method allows you to delete a specific component from cachet.

    $componentManager = ComponentFactory::build($cachetClient);
    $deleteComponent = $componentManager->deleteComponent($id);

$id (int) = component ID.


### Components Get

The get method allows you to get a specific component from cachet.

    $componentManager = ComponentFactory::build($cachetClient);
    $getComponent = $componentManager->getComponent($id);

###### $id (int) = component ID.

### Components Index

The index method allows you to get a list of component from cachet.

    $componentManager = ComponentFactory::build($cachetClient);
    $indexComponents = $componentManager->indexComponents($num, $page, $cache)

###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).

###### $cache (bool - default = true) = prefer cached components

### Components Search

The search method allows you to get one or more component from cachet searching by key's value.

    $componentManager = ComponentFactory::build($cachetClient);
    $cahedComponents = $componentManager->searchComponents($search, $by, $cache, $limit, $num, $page)


###### $search (mixed) = is the value to search for

###### $by (string) = is the column where search

###### $cache (bool - default = true) = prefer cached components

###### $limit (int - default = 1) = number of components to return

###### $num (int - default = 1000) = is the number of component to return from a single page (uses cachet pagination).

###### $page (int - default = 1) = is the page number (uses cachet pagination).

### Components Store

The store method allows you to add a component.

    $componentManager = ComponentFactory::build($cachetClient);
    $cahedComponents = $componentManager->storeComponent($component)

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

### Components Update


The update method allows you to update a  specific component.

    $componentManager = ComponentFactory::build($cachetClient);
    $cahedComponents = $componentManager->storeComponent($id, $component)

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

