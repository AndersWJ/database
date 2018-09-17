<?php

namespace Awj\Database;

use Exception;
use Awj\Database\Connection\Mysql;
use Awj\Database\Connection\Sqlite;
use Awj\Database\Connection\Connection;

class DatabaseManager
{
    protected static $instance;
    protected $connections = [];
    protected $connectionTypes = [
        'mysql'  => Mysql::class,
        'sqlite' => Sqlite::class
    ];

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($method, $parameters)
    {
        if ($method == 'newQuery') {
            return self::defaultConnection()->newQuery();
        }

        throw new Exception('Method Not found');
    }

    /**
     * @return DatabaseManager
     *
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            throw new Exception('No global database manager has been initiated');
        }

        return self::$instance;
    }

    /**
     * @param $name
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function connection($name)
    {
        return self::getInstance()->getConnection($name);
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public static function defaultConnection()
    {
        return self::getInstance()->getConnection();
    }

    /**
     * @param array $config
     * @param string $connectionName
     *
     * @return DatabaseManager
     *
     * @throws Exception
     */
    public function addConnection(array $config, $connectionName = 'default')
    {
        if (!array_key_exists('type', $config)) {
            throw new Exception('No connection type has been set');
        }

        if (!array_key_exists($config['type'], $this->connectionTypes)) {
            throw new Exception('Connection type does not exist');
        }

        $connection = new $this->connectionTypes[$config['type']]($config);

        $this->connections[$connectionName] = $connection;

        return $this;
    }

    /**
     * @return array
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * @param string $connectionName
     *
     * @return Connection
     *
     * @throws Exception
     */
    public function getConnection($connectionName = 'default')
    {
        if (!array_key_exists($connectionName, $this->connections)) {
            throw new Exception('Connection not found');
        }

        return $this->connections[$connectionName];
    }

    /**
     *
     */
    public function setAsGlobal()
    {
        self::$instance = $this;
    }
}
