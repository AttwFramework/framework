<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Autoloader;

use Attw\Autoloader\Autoloadable\AutoloadableInterface;
use \SplObjectStorage;

class Autoloader
{
    /**
     * Collecion with autoloadiables
     *
     * @var \SplObjectStorage
    */
    private $autoloadables;

    public function __construct()
    {
        $this->autoloadables = new SplObjectStorage();
    }

    /**
     * Attach a autoloadiable
     *
     * @param \Attw\Autoloader\AutoloadableInterface
    */
    public function attach(AutoloadableInterface $autoloadable)
    {
        if ($this->autoloadables->contains($autoloadable)) {
            throw new \Exception('The autoload has been duplicated');
        }

        $this->autoloadables->attach($autoloadable);

        spl_autoload_register($autoloadable->getCallable());
    }

    /**
     * Detach a autoloadiable
     *
     * @param \Attw\Autoloader\AutoloadableInterface
    */
    public function detach(AutoloadableInterface $autoloadable)
    {
        if (!$this->autoloadables->contains($autoloadable)) {
            throw new \Exception('The autoload hasn\'t been duplicated');
        }

        $this->autoloadables->detach($autoloadable);

        spl_autoload_unregister($autoloadable->getCallable());
    }

    /**
     * Get all autoloadiables
     *
     * @return \SplObjectStorage
    */
    public function getAll()
    {
        return $this->autoloadables;
    }
}