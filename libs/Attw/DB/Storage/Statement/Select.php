<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Db\Storage\Statement;

use Attw\Db\Connection\ConnectorInterface;
use Attw\Db\Sql\SQLGenerator;

/**
 * Select SQL statement
*/
class Select
{
    /**
     * Connector instance
     *
     * @var \Attw\Db\Connection\ConnectorInterface
    */
    private $connector;

    /**
     * SQL generator instance
     *
     * @var \Attw\Db\Sql\SQLGenerator
    */
    private $sqlGenerator;

    /**
     * SQL query
     *
     * @var object|string
    */
    private $sql;

    /**
     * Prepared statement
     *
     * @var object
    */
    private $stmt;

    /**
     * Parameters of clauses
     *
     * @var array
    */
    private $parameters = array();

    /**
     * @param \Attw\Db\Connection\ConnectorInterface $connector
     * @param string                 $container
     * @param array|string               $data
    */
    public function __construct(ConnectorInterface $connector, SQLGenerator $sqlGenerator)
    {
        $this->connector = $connector;
        $this->sqlGenerator = $sqlGenerator;
    }

    /**
     * Create SQL select statement
     *
     * @param string       $container
     * @param string|array $data
    */
    public function create($container, $data = '*')
    {
        $this->sql = $this->sqlGenerator->select($container, $data);
        $this->defineStmt($this->sql);
        return $this;
    }

    /**
     * Where clause
     *
     * @param array|string
    */
    public function where($where)
    {
        $whereVars = array();

        if (is_array($where)) {
            foreach ($where as $column => $value) {
                $whereVars[] = sprintf('`%s` = :%s_where', $column, $column);
                $this->parameters[ $column . '_where' ] = $value;
            }

            $where = implode(' AND ', $whereVars);
        }

        $this->sql = $this->sql->where($where);
        $this->defineStmt($this->sql);
        $this->execAllBindParams();

        return $this;
    }

    /**
     * GroupBy clause
     *
     * @param string $groupBy
    */
    public function groupBy($groupBy)
    {
        $this->sql = $this->sql->groupBy($groupBy);
        $this->defineStmt($this->sql);
        $this->execAllBindParams();

        return $this;
    }

    /**
     * OrderBy clause
     *
     * @param string      $orderBy
     * @param string|null $type
    */
    public function orderBy($orderBy, $type)
    {
        $this->sql = $this->sql->orderBy($orderBy, $type);
        $this->defineStmt($this->sql);
        $this->execAllBindParams();

        return $this;
    }

    /**
     * Offset clause
     *
     * @param string $offset
    */
    public function offset($offset)
    {
        $this->sql = $this->sql->offset($offset);
        $this->defineStmt($this->sql);
        $this->execAllBindParams();

        return $this;
    }

    /**
     * Limit clause
     *
     * @param integer      $offset
     * @param integer|null $limit
    */
    public function limit($offset, $limit = null)
    {
        $offset = (is_null($limit)) ? 0 : $offset;
        $limit = (is_null($limit)) ? $offset : $limit;

        $this->sql = $this->sql->limit($offset, $limit);
        $this->defineStmt($this->sql);
        $this->execAllBindParams();

        return $this;
    }

    private function defineStmt($sql)
    {
        $this->stmt = $this->connector->getStatement($sql);
    }

    /**
     * @param
    */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method)) {
            if (!method_exists($this->stmt, $method)) {
                throw new \Exception('Method not found: ' . $method);
            }

            return call_user_func_array(array($this->stmt, $method), $args);
        }

        return call_user_func_array(array($this, $method), $args);
    }

    private function execAllBindParams()
    {
        foreach ($this->parameters as $key => $value) {
            $this->stmt->bindValue($key, $value);
        }
    }
}