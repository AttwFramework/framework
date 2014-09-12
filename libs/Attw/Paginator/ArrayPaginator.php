<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Paginator;

use Attw\Paginator\PaginatorInterface;
use Attw\Paginator\PaginatorSort;

/**
 * Paginate an array
 *
 * @example
 * $array = [ '1', '2', '3', '4', '5', '6' ];
 * $paginator = new ArrayPaginator($array, 2, 2, PaginatorSort::SORT_DESC);
 * $arrayPaginated = $paginator->getPaginated();
 * print_r($arrayPaginated);
 * // array([0] => 4, [1] => 3)
*/
class ArrayPaginator implements PaginatorInterface
{
    /**
     * Data to paginate
     *
     * @var array
    */
    private $data;

    /**
     * Limit of pagination
     *
     * @var integer
    */
    private $limit;

    /**
     * Current page of pagination
     *
     * @var integer
    */
    private $currentPage;

    /**
     * Organization type
     *
     * @var string (asc|desc)
    */
    private $sort;

    /**
     * Array already paginated
     *
     * @var array
    */
    private $slicedArray;

    /**
     * Constructor of paginator
     *
     * @param array $data data to paginate
     * @param integer $limit limit per page
     * @param integer $currentPage current page number of pagination
     * @param string $sort organization type. Can be asc (Paginator\ArrayPaginator::SORT_ASC) or desc (Paginator\ArrayPaginator::SORT_DESC)
     * @throws \UnexpectedValueException case param $sort is diferent of
     *  Paginator\ArrayPaginator::SORT_ASC and Paginator\ArrayPaginator::SORT_DESC
    */
    public function __construct(array $data, $limit, $currentPage, $sort = null)
    {
        $this->data = $data;
        $this->limit = (int) ceil($limit);
        $this->currentPage = $currentPage - 1;

        $sort = trim($sort);
        
        if (!is_null($sort) && $sort !== '') {
            if (strtolower($sort) != PaginatorSort::ASC && strtolower($sort) != PaginatorSort::DESC) {
                throw new \UnexpectedValueException('The sort must be ascendant or descendant');
            }
        }

        $this->sort = (!is_null($sort) && $sort !== '') ? $sort : null;

        $this->createArrayPaginated();
    }

    /**
     * Paginate the array and set $this->slicedArray
    */
    private function createArrayPaginated()
    {
        if (!is_null($this->sort)) {
            if ($this->sort == PaginatorSort::ASC) {
                arsort($this->data);
            } elseif ($this->sort == PaginatorSort::DESC) {
                krsort($this->data);
            }
        }

        $currentIndex = ($this->currentPage * $this->limit);
        $sliced = array_slice($this->data, $currentIndex, $this->limit);

        $this->slicedArray = $sliced;
    }

    /**
      * Get the array paginated
      *
      * @return array $this->slicedArray
    */
    public function getPaginated()
    {
        return $this->slicedArray;
    }

    /**
     * Count how pages was paginated
     * @see Countable Interface
     *
     * @return integer
    */
    public function count()
    {
        return ceil(count($this->data) / $this->limit);
    }

    /**
     * Current page of pagination
     *
     * @return integer $this->currentPage
    */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
    }
