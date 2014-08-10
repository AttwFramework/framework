File
====
[![Total Downloads](https://poser.pugx.org/attwframework/file/downloads.png)](https://packagist.org/packages/attwframework/file) [![Latest Unstable Version](https://poser.pugx.org/attwframework/file/v/unstable.png)](https://packagist.org/packages/attwframework/file) [![License](https://poser.pugx.org/attwframework/file/license.png)](https://packagist.org/packages/attwframework/file)

File component of [AttwFramework](https://github.com/attwframework/framework).

##Composer autoload
```json
{
    "autoload": {
    "psr-4": {
        "Attw\File\\": "vendor/attwframework/file/"
    }
    }
}
```
##How to use
A file is represented with the class ```Attw\File\File```.

Pass in it constructor an array with file datils (global variable $_FILES).
```php
use Attw\File\File;

//...

$file = new File($_FILES['file']);
```
All components of namespace ```Attw\File``` use the file class.
###Upload
To upload a file, use the class ```Attw\File\Uploader\Uploader```.

The method used to upload a file is ```Attw\File\Uploader\Uploader::upload($file, $directory)```.
```php
use Attw\File\File;
use Attw\File\Uploader\Uploader;

//...

$file = new File($_FILES['file']);
$uploader = new Uploader();
if($uploader->upload($file, 'public/files')){
    //success
}
```
###File validators
Also have the possibility of validate the files.

The validators are:
* ```Attw\File\Validator\MaxSize```: Don't allow that a file have more than specified maximum size
 * Constructor: ```Attw\File\Validator\MaxSize::__construct($maxSize)```. ```$maxSize``` must be an integer and indicated in MB
* ```Attw\File\Validator\MinSize```: Don't allow that a file have more than specified minimum size
 * Constructor: ```Attw\File\Validator\MinSize::__construct($minSize)```. ```$minSize``` must be an integer and indicated in MB
* ```Attw\File\Validator\Extension```: Don't allow that a file have a invalid extension
 * Constructor: ```Attw\File\Validator\Extenction::__construct($extensions)```. ```$extensions``` must be an array with the allowed extensions.
* ```Attw\File\Validator\Type```: Don't allow that a file have a invalid type
 * Constructor: ```Attw\File\Validator\Type::__construct($types)```. ```$types``` must be an array with the allowed types.

```php
use Attw\File\File;
use Attw\File\Validator\Extension;

//...

$file = new File($_FILES['file']);
$validator = new Extension([ 'jpg', 'png', 'gif' ]);

if($validator->validate($file)){
    //success
}
```
If you wanna throw an exception (```Attw\File\Validator\Exception\FileValidatorException```) when the validation fail, execute the method ```Attw\File\Validator\SomeValidator::exception($on = false)``` with the param ```$on``` as ```true```.
