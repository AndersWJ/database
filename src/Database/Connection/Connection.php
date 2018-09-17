<?php

namespace Awj\Database\Connection;

use Awj\Database\Grammar\Grammar;
use PDO;
use Awj\Database\QueryBuilder;

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
     * @return QueryBuilder
     */
    public function newQuery()
    {
        return new QueryBuilder($this);
    }

    /**
     * Connects to the database
     */
    abstract public function connect();

    /**
     * @return Grammar
     */
    abstract public function getGrammar();
}
