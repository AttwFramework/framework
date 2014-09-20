<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\DB\SQL\MySQL\Statement;

use Attw\DB\SQL\MySQL\Statement\AbstractStatementWithWhere;
use Attw\DB\SQL\MySQL\Operator\Equal;
use Attw\DB\SQL\MySQL\Operator\AndOperator;
use Attw\DB\SQL\MySQL\Clause\From;

/**
 * MySQL SQL Delete statement
*/
class Delete extends AbstractStatementWithWhere
{
    /**
     * Table to delete some registries
     *
     * @var \Attw\DB\SQL\MySQL\Clause\From
    */
    private $table;

    /**
     * Contruct a delete statement
     *
     * @param string $table
     * @param array|string $where can be array or a string
    */
    public function __construct($table, $where)
    {
        $this->table = new From($table);
        $this->constructWhere($where);
    }

    /**
     * Construct the delete SQL
    */
    protected function constructSql()
    {
        $this->sql = sprintf('DELETE %s %s',
                $this->table,
                $this->where);
    }
}