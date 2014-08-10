Event
======
[![Total Downloads](https://poser.pugx.org/attwframework/event/downloads.png)](https://packagist.org/packages/attwframework/event) [![Latest Unstable Version](https://poser.pugx.org/attwframework/event/v/unstable.png)](https://packagist.org/packages/attwframework/event) [![License](https://poser.pugx.org/attwframework/event/license.png)](https://packagist.org/packages/attwframework/event)

Events component of [AttwFramework](https://github.com/attwframework/framework).

[Tests](https://github.com/AttwFramework/framework/tree/master/tests/Attw/Event)
##Composer
###Download
```json
{
    "require": {
        "attwframework/event": "dev-master"
    }
}
```
###Autoload
```json
{
    "autoload": {
        "psr-4": {
            "Attw\Event\\": "vendor/attwframework/event/"
        }
    }
}
```
##How to use
###Creating an event
First, create an instance of ```Attw\Event\EventManager```:
```php
use Attw\Event\EventManager;

$eventManager = EventManager::getInstance();
```
After, create a listener. The listener will do the actions of an event.
It can be a callable function
```php
$eventManager->listen('after_login', function ($event) {
    $params = $event->getParams();
    $username = $params['username'];
    
    echo 'Welcome ' . $username;
});
```
or a class that implements ```Attw\Event\EventListenerInterface```:
```php
namespace You\Namespace\Event\Listener;

use Attw\Event\EventListenerInterface;

class UserListener implements EventListenerInterface
{
    public function afterLogin(Event $event)
    {
        $params = $event->getParams();
        $username = $params['username'];
    
        echo 'Welcome ' . $username;
    }
}
```
```php
$eventManager->listen('after_login', 'You\Namespace\Event\Listener\UserListener.afterLogin');
```
> **Note:** Listeners always receive an event as a parameter.

###Throwing an event
Create an instance of ```Attw\Event\Event``` and set the params necessary to listener
```php
use Attw\Event\Event;

$event = new Event();
$event->setParams(array('username' => $user->getName()));

$eventManager->trigger('after_login', $event);
```
###Custom events
Example
```php
namespace You\Namespace\Event;

use Attw\Event\Event;

class UserEvent extends Event
{
    private $user;

    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
}
```
###Prioritizing an event
Pass as third argument the number of order of prioritizing.
```php
$eventManager->listen('some_name', 'You\Namespace\Event\Listener\YourListener.methodName1', 2);//The last to be executed
$eventManager->listen('some_name', 'You\Namespace\Event\Listener\YourListener.methodName2', 4);//The first to be executed
$eventManager->listen('some_name', 'You\Namespace\Event\Listener\YourListener.methodName3', 3);//The second to be executed
```
###Removing an event
Use method ```Attw\Event\EventManager::unlisten($name = null, $listener = null)```.

Removing by name
```php
$eventManager->unlisten('some_name');
```
Removing by listener (remove this listeners of all events)
```php
$eventManager->unlisten(null, 'You\Namespace\Event\Listener\YourListener.methodName');
```
Removing by name and listener (remove listener of an event)
```php
$eventManager->unlisten('some_name', 'You\Namespace\Event\Listener\YourListener.methodName');
```
