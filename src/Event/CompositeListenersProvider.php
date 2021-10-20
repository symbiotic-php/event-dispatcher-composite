<?php

namespace Symbiotic\Event;


use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class CompositeEventDispatcher
 * @package Symbiotic\Core\Events
 * @copyright Yiisoft
 *
 * @link https://github.com/yiisoft/event-dispatcher/blob/master/src/Provider/CompositeProvider.php
 */
class CompositeListenersProvider implements ListenerProviderInterface
{
    protected $providers = [];

    public function getListenersForEvent(object $event): iterable
    {
        foreach ($this->providers as $provider) {
            yield from $provider->getListenersForEvent($event);
        }
    }

    /**
     * Add provider
     * @param ListenerProviderInterface $provider
     */
    public function attach(ListenerProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }


}
