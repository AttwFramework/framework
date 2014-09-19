<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Event;

use Attw\Event\EventDispacherInterface;
use Attw\Event\Exception\EventException;
use Attw\Event\Event;
use \InvalidArgumentException;

/**
 * Event manager, to add and throw events
*/
class EventManager implements EventManagerInterface
{
    /**
     * All listeners
     *
     * @var array
    */
    private $events = array();

    /**
     * Add a listener
     *
     * @param string $name
     * @param array | callable $listener
     * @param integer $priority
     * @throws \InvalidArgumentException case $name is not a string
     * @throws \Attw\Event\Exception\EventException case $listener is string
     *  and params is not correctly setted
     * @throws \Attw\Event\Exception\EventException case $listener does not exists
     * @throws \Attw\Event\Exception\EventException case $listener does not implements
     *  Attw\Event\EventListenerInterface
     * @throws \Attw\Event\Exception\EventException case method of listener does not exists
     * @throws \InvalidArgumentException case $priority is not an integer
    */
    public function listen($name, $listener, $priority = 0)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Name must be integer');
        }

        if (is_string($listener)) {
            $listenerParams = explode('.', $listener);

            if (!isset($listenerParams[1])) {
                throw new EventException('Choose the listener and the method to event');
            }

            if (!class_exists($listenerParams[0])) {
                throw new EventException('Listener not found: ' . $listenerParams[0]);
            }

            $listenerClass = $listenerParams[0];

            if (!(new $listenerClass() instanceof EventListenerInterface)) {
                throw new EventException('Listener must implements Attw\Event\EventListenerInterface: ' . $listenerParams[0]);
            }

            if (!method_exists(new $listenerClass(), $listenerParams[1])) {
                throw new EventException(sprintf('Method not found in listener %s: %s',
                $listenerClass,
                $listenerParams[1]));
            }
        }

        if (!is_int($priority)) {
            throw new InvalidArgumentException('Priority must be integer');
        }

        $this->events[ $name ][] = array(
            'listener' => $listener,
            'priority' => $priority
       );
    }

    /**
     * Remove a listener
     *
     * @param string $name
     * @param callable | string $listener
    */
    public function unlisten($name = null, $listener = null)
    {
        if (!is_null($name) && is_null($listener)) {
            unset($this->events[ $name ]);
        } elseif (is_null($name) && !is_null($listener)) {
            foreach ($this->events as $eName => $eEvent) {
                foreach ($eEvent as $key => $eventP) {
                    if ($listener == $eventP['listener']) {
                        unset($this->events[ $eName ][ $key ]);
                    }
                }
            }
        } elseif (!is_null($name) && !is_null($listener)) {
            foreach ($this->events as $eName => $eEvent) {
                foreach ($eEvent as $key => $eventP) {
                    if ($eName == $name && $listener == $eventP['listener']) {
                        unset($this->events[ $eName ][ $key ]);
                    }
                }
            }
        }
    }

    /**
     * Throw a listener
     *
     * @param string $name
     * @param \Attw\Event\Event
    */
    public function trigger($name, Event $event)
    {
        if (isset( $this->events[$name])) {
            $events = $this->getSorted($this->events[$name]);

            foreach ($events as $eventP) {
                $listener = $eventP['listener'];
                if (is_callable( $listener ) ) {
                    $listener($event);
                } elseif ( is_string($listener)) {
                    $listenerParams = explode('.', $listener);
                    $listener = $listenerParams[0];
                    $method = $listenerParams[1];

                    $listenerInstance = new $listener();
                    $listenerInstance->{$method}($event);
                }
            }
        }
    }

    /**
     * Sorts events by priority
     *
     * @param array $arr
     * @return array
    */
    private function getSorted(array $arr)
    {
        $events = array();
        $arrToSort = array();
        foreach ($arr as $key => $eventP) {
            $arrToSort[$key] = $eventP['priority'];
        }

        arsort($arrToSort);

        foreach ($arrToSort as $key => $priority) {
            $events[$key] = array(
                'listener' => $arr[ $key ]['listener'],
                'priority' => $priority
            );
        }

        return $events;
    }
}