<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Auth;

use Attw\Auth\AuthModelInterface;
use Attw\DB\Storage\StorageInterface;

class DbAuthenticator implements AuthenticatorInterface
{
    /**
     * @var \Attw\DB\Storage\StorageInterface
    */
    private $storage;

    /**
     * @param \Attw\DB\Storage\StorageInterface $storage
    */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Authenticate the login data
     *
     * @param \Attw\Auth\AuthModelInterface $authData
     * @param string                        $passwordField
     * @param array                         $data
     * @return boolean
    */
    public function authenticate(AuthModelInterface $authData, $passwordField, array $data)
    {
        $password = $authData->getEncrypter()->encrypt($data[$passField]);
        $data[$passField] = $password;

        $stmt = $this->storage->read($authData->getTable());
        $stmt->where(array_combine($authData->getFields(), $data));
        $stmt->execute();
        return $stmt->rowCount() > 0 ? true : false;
    }
}