<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Awj\Database\DatabaseManager;

class DatabaseTest extends TestCase
{
    /** @test
     * @throws \Exception
     */
    public function it_can_test()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();
        $db->addConnection($config);
        $db->setAsGlobal();

        $pdo = $db->getConnection()->getPDO()->prepare('create table user (username text)');
        $pdo->execute();

        $pdo = $db->getConnection()->getPDO()->prepare('insert into user select "benny"');
        $pdo->execute();

        $queryBuilder = DatabaseManager::newQuery();

        $queryBuilder->table('user')->all();

        $this->assertEquals(['user' => 'benny'], $queryBuilder);
    }
}
