<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Db\Storage;

use Attw\Db\Storage\StorageInterface;
use Attw\Db\Connection\ConnectorInterface;
use Attw\Db\Sql\SQLGenerator;
use Attw\Db\Storage\Statement\Select as StorageSelect;

/**
 * Storage class for relational databases
*/
class Storage implements StorageInterface
{
    /**
     * Connector instance
     *
     * @var \Attw\Db\Connection\ConnectorInterface
    */
    private $connector;

    /**
     * SQL generator
     *
     * @var \Attw\Db\Sql\SQLGenerator
    */
    private $sqlGenerator;

    /**
     * @param \Attw\Db\Connection\ConnectorInterface $connector
     * @param \Attw\Db\Sql\SQLGenerator          $sql
    */
    public function __construct(ConnectorInterface $connector, SQLGenerator $sql)
    {
        $this->connector = $connector;
        $this->sqlGenerator = $sql;
    }

    /**
     * Insert something in database
     *
     * @param string $container
     * @param array  $data
    */
    public function create($container, array $data)
    {
        $dataVars = array();

        foreach ($data as $column => $value) {
            $dataVars[ $column ] = '?';
        }

        $sql = $this->sqlGenerator->insert($container, $dataVars, false);
        return $this->method($sql, $data);
    }

    /**
     * Delete some registry from database
     *
     * @param string $container
     * @param array  $where
    */
    public function remove($container, array $where)
    {
        $whereVars = array();

        foreach ($where as $column => $value) {
            $whereVars[] = sprintf('`%s` = ?', $column);
        }

        $sql = $this->sqlGenerator->delete($container, implode(' AND ', $whereVars));
        return $this->method($sql, $where);
    }

    /**
     * Update some registry in database
     *
     * @param string $container
     * @param array  $data
     * @param array  $where
    */
    public function update($container, array $data, array $where)
    {
        $dataVars = array();
        $whereVars = array();

        foreach ($data as $column => $value) {
            $dataVars[ $column ] = sprintf(':%s_data', $column);
        }

        foreach ($where as $column => $value) {
            $whereVars[ $column ] = sprintf(':%s_where', $column);
        }

        $sql = $this->sqlGenerator->update($container, $dataVars, $whereVars);

        $stmt = $this->connector->getStatement($sql);

        $stmt = $this->bindAllParams($stmt, $data, '_data');
        $stmt = $this->bindAllParams($stmt, $where, '_where');

        return $stmt;
    }

    /**
     * Find some registry in database
     *
     * @param string       $container
     * @param array|string $data
    */
    public function read($container, $data = '*')
    {
        $query = new StorageSelect($this->connector, $this->sqlGenerator);

        return $query->create($container, $data);
    }

    /**
     * @param \Attw\Db\Statement\StatementInterface $stmt
     * @param array                                 $params
     * @param string|null                           $prefix
     * @return \Attw\Db\Statement\StatementInterface
    */
    private function bindAllParams($stmt, array $params, $prefix = null)
    {
        foreach ($params as $key => $value) {
            (is_null($prefix)) ? $stmt->bindParam($key + 1, $value) : $stmt->bindParam($key . $prefix, $value);
        }

        return $stmt;
    }

    private function method($sql, array $data)
    {
        $stmt = $this->connector->getStatement($sql);
        $stmt = $this->bindAllParams($stmt, array_values($data));
        return $stmt;
    }
}