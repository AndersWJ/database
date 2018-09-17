<?php

namespace Awj\Database\Connection;

use Awj\Database\Grammar;
use PDO;

class Mysql extends Connection
{
    /**
     * Connects to the database
     */
    public function connect()
    {
        $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s", $this->configuration['host'], $this->configuration['port'], $this->configuration['database']);
        $this->pdo = new PDO($dsn, $this->configuration['username'], $this->configuration['password']);
    }

    public function getGrammar()
    {
        return new Grammar\Mysql();
    }
}