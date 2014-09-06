<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Auth;

interface AuthenticatorInterface
{
    /**
     * Authenticate the login data
     *
     * @param \Attw\Auth\AuthModelInterface $authData
     * @param string                        $passwordField
     * @param array                         $data
     * @return boolean
    */
    public function authenticate(AuthModelInterface $authData, $passwordField, array $data)
}