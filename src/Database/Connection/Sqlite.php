<?php

namespace Awj\Database\Connection;

use PDO;

class Sqlite extends Connection
{
    /**
     * Connects to the database
     */
    public function connect()
    {
        $dsn = sprintf("sqlite:%s", $this->configuration['database']);
        $this->pdo = new PDO($dsn);
    }
}
