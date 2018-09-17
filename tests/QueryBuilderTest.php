<?php

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase;
use Awj\Database\Connection\Sqlite as SqliteConnection;

class QueryBuilderTest extends TestCase
{
    /** @test */
    public function it_can_test()
    {
        $connection = new SqliteConnection([
            'database' => ':memory:'
        ]);

        $this->assertInstanceOf(PDO::class, $connection->getPDO());
    }
}
