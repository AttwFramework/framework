<?php
    namespace Test\Attw\HTTP;

    use Attw\HTTP\Request;
    use \PHPUnit_Framework_TestCase;

    class RequestTests extends PHPUnit_Framework_TestCase
    {
        public function assertPreConditions()
        {
            $this->assertTrue(
                class_exists( 'Attw\HTTP\Request' ),
                'Class for requests not found: Attw\HTTP\Request'
            );
        }

        public function testConstructorEmpty()
        {
            $_GET['name'] = 'Gabriel';
            $request = new Request();

            $this->assertTrue( $request->issetQuery( 'name' ) );
            $this->assertEquals( 'Gabriel', $request->query( 'name' ) );
        }

        public function testConstructorWithArrays()
        {
            $request = new Request( array( 'email' => 'email@email.com' ) );

            $this->assertTrue( $request->issetQuery( 'email' ) );
            $this->assertEquals( 'email@email.com', $request->query( 'email' ) );
        }

        public function testPostMethods()
        {
            $request = new Request( array(), array( 'name' => 'Gabriel' ) );

            $this->assertTrue( $request->issetPost( 'name' ) );
            $this->assertFalse( $request->issetPost( 'age' ) );
            $this->assertEquals( 'Gabriel', $request->post( 'name' ) );
        }

        public function testQueryMethods()
        {
            $request = new Request( array( 'name' => 'Gabriel' ) );

            $this->assertTrue( $request->issetQuery( 'name' ) );
            $this->assertFalse( $request->issetQuery( 'age' ) );
            $this->assertEquals( 'Gabriel', $request->query( 'name' ) );
        }

        public function testFileMethods()
        {
            $files = array( 'someimage' =>
                'size' => 1024,
                'tmp_name' => __FILE__,
                'name' => 'img.jpg',
                'type' => 'image/jpeg',
                'error' => null
            );

            $request = new Request( array(), array(), $files );

            $this->assertTrue( $request->issetFile( 'someimage' ) );
            $this->assertFalse( $request->issetFile( 'sometxt' ) );
            $this->assertEquals( $files['someimage'], $request->files( 'someimage' ) );
        }

        public function testServerMethods()
        {
            $request = new Request( array(), array(), array(), array( 'REQUEST_URI' => __FILE__ ) );

            $this->assertTrue( $request->issetServer( 'REQUEST_URI' ) );
            $this->assertFalse( $request->issetServer( 'REQUEST_TIME' ) );
            $this->assertEquals( __FILE__, $request->server( 'REQUEST_URI' ) );
        }

        public function testGetterForRequestMethod()
        {
            $request = new Request( array(), array(), array(), array( 'REQUEST_METHOD' => 'POST' ) );

            $this->assertEquals( 'POST', $request->getMethod() );
        }
    }
