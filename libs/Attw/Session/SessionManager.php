<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Session;

use \UnexpectedValueException;

/**
 * Session manager
*/
class SessionManager
{
    /**
     * Return if sessions is started
     *
     * @var boolean
    */
    private $started = false;

    /**
     * Start all sessions
    */
    public function startAll()
    {
        if (!$this->isStarted()) {
            session_start();
            $this->started = true;
        }
    }

    /**
     * Destroy all sessions
    */
    public function destroyAll()
    {
        session_destroy();
        $this->started = false;
    }

    /**
     * Destroy one session
     *
     * @param string $name
    */
    public function destroy($name)
    {
        if ($this->exists($name)) {
            unset($_SESSION[ $name ]);
        }
    }

    /**
     * Verify if session are starteds
     *
     * @return boolean
    */
    public function isStarted()
    {
        return isset($_SESSION);
    }

    /**
     * Get value of a session
     *
     * @param string $name Session name
     * @throws \UnexpetedValueException case Session doesn't exists
    */
    public function get($name)
    {
        if ($this->exists($name)) {
            return $_SESSION[ $name ];
        }

        throw new UnexpectedValueException(sprintf('Session doesn\'t started: %s', $name));
    }

    /**
     * Create or set a session
     *
     * @param string $name
     * @param mixed $value
    */
    public function set($name, $value)
    {
        if (!$this->isStarted()) {
            $this->startAll();
        }

        $_SESSION[ $name ] = $value;
    }

    /**
     * Veirify if a session exists
     *
     * @param string $name
     * @return boolean
    */
    public function exists($name)
    {
        if (!$this->isStarted()) {
            $this->startAll();
        }

        return isset($_SESSION[ $name ]);
    }
}