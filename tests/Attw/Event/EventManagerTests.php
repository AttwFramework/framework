<?php
    namespace Test\Attw\Event;

    use Attw\Event\EventManager;
    use Attw\Event\Event;
    use \PHPUnit_Framework_TestCase;

    class EventManagerTests extends PHPUnit_Framework_TestCase
    {
        public function assertPreConditions()
        {
            $this->assertTrue(
                class_exists( 'Attw\Event\EventManager' ),
                'Class for manage events not found: Attw\Event\EventManager'
            );
        }

        public function testAddAListenerCalableAndThrowIt()
        {
            $eventManager = EventManager::getInstance();

            $eventManager->listen( 'user', function ($event) {
                $params = $event->getParams();
                $username = $params['username'];

                $_SERVER['event_username'] = $username;
            } );

            $event = new Event();
            $event->setParams( array( 'username' => 'gabrieljmj' ) );
            $eventManager->trigger( 'user', $event );

            $this->assertEquals( 'gabrieljmj', $_SERVER['event_username'] );
        }

        /**
		 * @expectedException \Attw\Event\Exception\EventException
		*/
        public function testRemoveAListener()
        {
            $eventManager = EventManager::getInstance();

            $eventManager->listen( 'foo', function ($event) { return true; } );
            $eventManager->unlisten( 'foo' );
            $eventManager->trigger( 'foo', new Event() );
        }

        public function testWithListenerClass()
        {
            $eventManager = EventManager::getInstance();

            $eventManager->listen( 'foo', 'Test\Attw\Event\FooListener.bar' );
            $event = new Event();
            $event->setParams( array( 'foobar' => 'abc' ) );
            $eventManager->trigger( 'foo', $event );

            $this->assertEquals( 'abc', $_SERVER['event_foobar'] );
        }

        public function testWithListenerClassAndCalable()
        {
            $eventManager = EventManager::getInstance();

            $eventManager->listen( 'foo', 'Test\Attw\Event\FooListener.bar' );
            $eventManager->listen( 'foo', function ($event) {
                $params = $event->getParams();

                $_SERVER['event_whatever'] = $params['whatever'];
            } );
            $event = new Event();
            $event->setParams( array( 'foobar' => 'abc', 'whatever' => 'def' ) );
            $eventManager->trigger( 'foo', $event );

            $this->assertEquals( 'abc', $_SERVER['event_foobar'] );
            $this->assertEquals( 'def', $_SERVER['event_whatever'] );
        }

        public function testPrioritizationOfListeners()
        {
            $eventManager = EventManager::getInstance();

            $eventManager->listen( 'a', function ($event) {
                $params = $event->getParams();

                $_SERVER['event_whatever'] = $params['bar'];
            }, 2 );

            $eventManager->listen( 'a', function ($event) {
                $params = $event->getParams();

                $_SERVER['event_whatever'] = $params['baz'];
            }, 3 );

            $event = new Event();
            $event->setParams( array( 'bar' => 'to eat', 'baz' => 'to bite' ) );

            $eventManager->trigger( 'a', $event );
            $this->assertEquals( 'to eat', $_SERVER['event_whatever'] );
        }
    }
