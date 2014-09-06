<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router\Exception;

use \Exception;

class UrlParserException extends Exception
{
	public function invalidUrl($url)
	{
		throw new UrlParserException('Invalid URL passed: ' . $url);
	}
}