<?php
    namespace Test\Attw\Event;

    use Attw\Event\Event;
    use \PHPUnit_Framework_TestCase;

    class EventTests extends PHPUnit_Framework_TestCase
    {
        public function assertPreConditions()
        {
            $this->assertTrue(
                class_exists( 'Attw\Event\Event' ),
                'Class for events not found: Attw\Event\Event'
            );
        }

        public function testParamsSetterAndGetter()
        {
            $params = array( 'foo' => 'bar' );

            $event = new Event();
            $event->setParams( $params );

            $params = $event->getParams();

            $this->assertTrue( is_array( $params ) );
            $this->assertArrayHasKey( 'foo', $params );
            $this->assertEquals( 'bar', $params['foo'] );
        }
    }
