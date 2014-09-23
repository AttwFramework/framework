HTTP
====

HTTP component of AttwFramework
##How to use
###Request
For you handle HTTP requests.

**Methods:**
* ```query($property)``` used to get some querystring request parameter (```$_GET```).
* ```post($property)``` used to get some post request parameter (```$_POST```).
* ```server($property)``` used to get infomations of headers, paths and script locations (```$_SERVER```).
* ```file($property)``` used to get some file passed on HTTP Post request (```$_FILES```)
* ```isQuery()``` used to verify if request is a querystring
* ```isPost()``` used to verify if request is a post
* ```isPut()``` used to verify if request is a put
* ```isDel()``` used to verify if request is a delete
* ```isAjax()``` used to verify if request is an ajax
* ```issetPost($property)``` used to verify if a post request exists
* ```issetQuery($property)``` used to verify if a querystring request exists
* ```issetFile($property)``` used to verify if a post request with a file exists
* ```issetServer($property)``` used to verifi if a property of server exists
* ```getMethod()``` used to get the current request method
* ```send(RequestInterface $request)``` used to send a request

To facilitate tests, you can pass the constructor of the class arrays with values of requests:
```php
use Attw\Http\Request;

$query = array('a' => 1, 'b' => 2);
$post = array('a' => 3, 'b' => 4);

$request = new Request($query, $post);
echo $request->query('a'); // 1
echo $request->post('b'); // 4
```
