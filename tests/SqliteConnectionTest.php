<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Awj\Database\Connection\Connection;
use Awj\Database\Connection\Sqlite as SqliteConnection;

class SqliteConnectionTest extends TestCase
{
    /** @test */
    public function it_can_be_newed_up()
    {
        $connection = new SqliteConnection([
            'database' => ':memory:'
        ]);

        $this->assertInstanceOf(SqliteConnection::class, $connection);
        $this->assertInstanceOf(Connection::class, $connection);
    }
}
