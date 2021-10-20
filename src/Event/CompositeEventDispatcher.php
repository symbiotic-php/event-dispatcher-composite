<?php

namespace Symbiotic\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;


/**
 * Class CompositeEventDispatcher
 * @package Symbiotic\Core\Events
 * @copyright Yiisoft
 * @link https://github.com/yiisoft/event-dispatcher/blob/master/src/Dispatcher/CompositeDispatcher.php
 */
class CompositeEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    protected $dispatchers = [];

    public function dispatch(object $event)
    {
        foreach ($this->dispatchers as $dispatcher) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                return $event;
            }
            $event = $dispatcher->dispatch($event);
        }

        return $event;
    }

    public function attach(EventDispatcherInterface $dispatcher)
    {
        $this->dispatchers[] = $dispatcher;
    }


}