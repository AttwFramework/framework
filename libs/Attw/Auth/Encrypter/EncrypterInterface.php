<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Auth\Encrypter;

interface EncrypterInterface
{
    /**
     * @return string
    */
    public function encrypt($string);
}