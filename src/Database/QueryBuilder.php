<?php

namespace Awj\Database;

use PDO;
use Awj\Database\Connection\Connection;

class QueryBuilder
{
    protected $connection;
    protected $table;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $name
     * @return $this
     */
    public function table($name)
    {
        $this->table = $name;

        return $this;
    }

    public function all()
    {
        $grammar = $this->connection->getGrammar();

        $query = $grammar->compileSelect($this->table, ['*']);

        $statement = $this->connection->getPDO()->prepare($query);

        $statement->execute();

        die(var_dump($statement->fetchAll(PDO::FETCH_OBJ)));
    }
}