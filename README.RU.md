## Композитный диспетчер событий PSR-14

## Установка
```
composer require symbiotic/event-dispatcher-composite

Также можно поставить реализацию "symbiotic/event-dispatcher"
Декоратор для кешируемых событий "symbiotic/event-dispatcher-cached"
```
## Использование Диспетчера

Композитный диспетчер дает возможность обработки событий несколькими Диспетчерами сразу.
```php

/**
 * @var Psr\EventDispatcher\ListenerProviderInterface $coreProvider
 * @var Psr\EventDispatcher\ListenerProviderInterface $appProvider
 **/
$core_dispatcher = new MyEventDispatcher($coreProvider);
$app_dispatcher = new MyEventDispatcher($appProvider);

$dispatcher = new  \Symbiotic\Event\CompositeEventDispatcher();
// добавляем сразу несколько диспетчеров для обработки
$dispatcher->attach($core_dispatcher);
$dispatcher->attach($app_dispatcher);


// Теперь обработка события будет производится сразу несколькими диспетчерами

$event = $dispatcher->dispatch(new MyEvent());


```
## Композитный провайдер Слушателей

Также можно реализовать обработку событий из нескольких источников , используя композицию провайдеров.
Такой подход используется во фреймворке для последовательного сбора слушателей в порядке приоритета (ядро->приложение->плагин).

```php

/**
 * @var Psr\EventDispatcher\ListenerProviderInterface $core_provider
 * @var Psr\EventDispatcher\ListenerProviderInterface $app_provider
 * @var Psr\EventDispatcher\ListenerProviderInterface $compositeProvider
 **/
$core_provider = new ListenerProvider();
$app_provider = new ListenerProvider();
// добавление слушателей в провайдеры... 

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

