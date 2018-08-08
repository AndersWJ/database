<?php

namespace Awj\Database\Connection;

use PDO;

abstract class Connection
{
    /**
     * Contains the configuration to connect to a database
     *
     * @var array $configuration
     */
    protected $configuration;
    /**
     * Holds the PDO object, once connected.
     *
     * @var PDO $pdo
     */
    protected $pdo;

    /**
     * Sqlite constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->configuration = $config;
        $this->connect();
    }

    /**
     * Gets the PDO
     *
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Connects to the database
     */
    abstract public function connect();
}
