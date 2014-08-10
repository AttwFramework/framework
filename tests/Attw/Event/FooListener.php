<?php
    namespace Test\Attw\Event;

    use Attw\Event\EventListenerInterface;
    use Attw\Event\Event;

    class FooListener implements EventListenerInterface
    {
        public function bar(Event $event)
        {
            $params = $event->getParams();
            $_SERVER['event_foobar'] = $params['foobar'];
        }
    }
