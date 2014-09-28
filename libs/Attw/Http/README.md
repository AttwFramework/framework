HTTP
====
[![Total Downloads](https://poser.pugx.org/attwframework/http/downloads.png)](https://packagist.org/packages/attwframework/http) [![Latest Unstable Version](https://poser.pugx.org/attwframework/http/v/unstable.png)](https://packagist.org/packages/attwframework/http) [![License](https://poser.pugx.org/attwframework/http/license.png)](https://packagist.org/packages/attwframework/http)

HTTP component of [AttwFramework](https://github.com/attwframework/framework).
##Composer
###Download
```json
{
    "require": {
        "attwframework/http": "dev-master"
    }
}
```
##How to use
###Request
This class exists to handle HTTP requests.
Each one has a property on ```\Attw\Http\Request``` that returns an instance of ```\Attw\Http\Request\Method\RequestsCollection```, that extends ```\Attw\Tool\Collection\ArrayCollection```.

The values of each property can be defined on constructor of the request class. If null (```array()```), the value will be the properties of the globals (```$_GET```, ```$_POST```, ```$_FILES```, ```$_SERVER```, ```$_COOKIE```).

**Parameters order:** ```Request([array $query = array(), [array $post = array(), [array $files = array(), [array $server = array(), [array $cookies = array()]]]]])```
####Example
With globals:
```php
use Attw\Http\Request;

$_GET['foo'] = 'bar';
$request = new Request();
echo $request->query->get('foo');// bar
```
Without globals:
```php
use Attw\Http\Request;

$request = new Request(['bar' => 'foo']);
echo $request->query->get('bar');// foo
```
###Response
With it you can send a response to client machine.
The response will send to the client if the request was executed with success (Status code is ```200```) or not (Status code is not ```200```), the content type to the brownser show (HTML, JSON, image, etc.) and others headers.

You can create a collection of headers to send all in the same time or send one each one.

On the instance of ```\Attw\Http\Response``` you can define the current status code and the version used of HTTP protocol:
```Response([$statusCode = 200, [$protocol = 'HTTP/1.1']])```.

####Example:
Sending one header:
```php
use Attw\Http\Response;

$response = new Response();
$response->sendHeader('Location', 'http://foo.bar'); //will redirect to http://foo.bar
```
Sending several headers:
```php
$response->addHeader('Content-type', 'text/html');
$response->addHeader('Charset=UTF-8');
$response->sendAllHeaders();
```
###Cookies
Cookies are, basically, some data that the server "ask" client to save.
Every time that you access that domain, your machine sends to it all cookies saved to it.
A cookie is exclusive of you, of your machine.

The class used to set cookies is ```\Attw\Http\Cookie\Cookies``` and used to read a cookie is ```\Attw\Http\Request```.
####Example
```php
use Attw\Http\Cookie\Cookie;
use Attw\Http\Cookie\Cookies;
use Attw\Http\Request;

$cookies = new Cookies();
$cookie = new Cookie('foo', 'bar');//name: foo; value: bat
$cookies->set($cookie);
$request = new Request();
echo $request->cookie->get('foo');// bar
```