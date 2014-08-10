<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Paginator;

use \Countable;

/**
 * Interface to paginators
 * Countable
*/
interface PaginatorInterface extends Countable
{
    /**
     * Get consult paginated
     *
     * @return array or object
    */
    public function getPaginated();

    /**
     * Get current index of pagination
     *
     * @return integer
    */
    public function getCurrentPage();
}