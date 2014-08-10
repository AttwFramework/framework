<?php
    namespace Test\Attw\HTTP;

    use Attw\HTTP\Request;
    use \PHPUnit_Framework_TestCase;

    class ResponseTests extends PHPUnit_Framework_TestCase
    {
        public function assertPreConditions()
        {
            $this->assertTrue(
                class_exists( 'Attw\HTTP\Response' ),
                'Class for responses not found: Attw\HTTP\Response'
            );
        }

        public function testSendStatusCode()
        {
            $response = new Response();
            $response->sendStatusCode( 404 );

            $this->assertEquals( 404, http_response_code() );
        }
    }
