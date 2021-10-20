## Composite Event Dispatcher-14

## Install
```
composer require symbiotic/event-dispatcher-composite

You can also put an implementation "symbiotic/event-dispatcher"
Decorator for cached events "symbiotic/event-dispatcher-cached"
```
## Using the Composite Dispatcher

Composite dispatcher makes it possible to process events by several Dispatchers at once.

```php

/**
 * @var Psr\EventDispatcher\ListenerProviderInterface $coreProvider
 * @var Psr\EventDispatcher\ListenerProviderInterface $appProvider
 **/
$core_dispatcher = new MyEventDispatcher($coreProvider);
$app_dispatcher = new MyEventDispatcher($appProvider);

$dispatcher = new  \Symbiotic\Event\CompositeEventDispatcher();
// we add several dispatchers for processing at once
$dispatcher->attach($core_dispatcher);
$dispatcher->attach($app_dispatcher);


// Now the event will be processed by several dispatchers at once

$event = $dispatcher->dispatch(new MyEvent());


```
## Composite Listener Provider

It is also possible to implement event handling from multiple sources using a composition of providers.
This approach is used in the framework to sequentially collect listeners in order of priority (core->application->plugin).
```php

/**
 * @var Psr\EventDispatcher\ListenerProviderInterface $core_provider
 * @var Psr\EventDispatcher\ListenerProviderInterface $app_provider
 * @var Psr\EventDispatcher\ListenerProviderInterface $compositeProvider
 **/
$core_provider = new ListenerProvider();
$app_provider = new ListenerProvider();
// adding listeners to providers... 

/**
 * @var Psr\EventDispatcher\ListenerProviderInterface|\Symbiotic\Event\CompositeListenersProvider $compositeProvider
 **/
$compositeProvider = new \Symbiotic\Event\CompositeListenersProvider();
$compositeProvider->attach($core_provider);
$compositeProvider->attach($app_provider);

/**
 * @var Psr\EventDispatcher\EventDispatcherInterface $dispatcher
 **/
$dispatcher = new MyEventDispatcher($compositeProvider);
 
$event = $dispatcher->dispatch(new MyEvent());

```

