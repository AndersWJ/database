<?php

namespace Tests;

use PDOException;
use PHPUnit\Framework\TestCase;
use Awj\Database\Connection\Connection;
use Awj\Database\Connection\Mysql as MysqlConnection;

class MysqlConnectionTest extends TestCase
{
    /** @test */
    public function it_can_be_newed_up()
    {
        $connection = new MysqlConnection([
            'host'     => '127.0.0.1',
            'port'     => '33066',
            'username' => 'admin',
            'password' => 'secret',
            'database' => 'testdb',
        ]);

        $this->assertInstanceOf(MysqlConnection::class, $connection);
        $this->assertInstanceOf(Connection::class, $connection);
    }

    /** @test */
    public function it_throws_a_pdo_exception_to_connect_if_dsn_is_invalid()
    {
        $this->expectException(PDOException::class);

        $connection = new MysqlConnection([
            'host'     => 'your_momma',
            'port'     => 'invalid_as_hell',
            'username' => 'admin_is_not_home',
            'password' => 'secret_shit',
            'database' => 'no_db',
        ]);
    }
}
