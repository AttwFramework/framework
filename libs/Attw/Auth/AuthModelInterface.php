<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Auth;

interface AuthModelInterface
{
    /**
     * Returns the table where the authentication will be done
     *
     * @return string
    */
    public function getTable();

    /**
     * Returns the fields of the table used to authentication
     *
     * @return array
    */
    public function getFields();

    /**
     * Returns what the method to encrypt the password
     *
     * @return \Attw\Auth\Encrypter\EncrypterInterface
    */
    public function getEncrypter();
}