<?php

namespace Tests;

use Awj\Database\Grammar;
use PDOException;
use PHPUnit\Framework\TestCase;
use Awj\Database\Connection;

class MysqlConnectionTest extends TestCase
{
    /** @test */
    public function it_can_be_newed_up()
    {
        $connection = new Connection\Mysql([
            'host'     => '127.0.0.1',
            'port'     => '33066',
            'username' => 'admin',
            'password' => 'secret',
            'database' => 'testdb',
        ]);

        $this->assertInstanceOf(Connection\Connection::class, $connection);
        $this->assertInstanceOf(Connection\Mysql::class, $connection);
    }

    /** @test */
    public function it_throws_a_pdo_exception_to_connect_if_dsn_is_invalid()
    {
        $this->expectException(PDOException::class);

        $connection = new Connection\Mysql([
            'host'     => 'your_momma',
            'port'     => 'invalid_as_hell',
            'username' => 'admin_is_not_home',
            'password' => 'secret_shit',
            'database' => 'no_db',
        ]);
    }

    /** @test */
    public function it_knows_which_grammar_to_use()
    {
        $connection = new Connection\Mysql([
            'host'     => '127.0.0.1',
            'port'     => '33066',
            'username' => 'admin',
            'password' => 'secret',
            'database' => 'testdb',
        ]);

        $this->assertInstanceOf(Grammar\Grammar::class, $connection->getGrammar());
        $this->assertInstanceOf(Grammar\Mysql::class, $connection->getGrammar());
    }

}
