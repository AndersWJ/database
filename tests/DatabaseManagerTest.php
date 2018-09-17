<?php

namespace Tests;

use Exception;
use Awj\Database\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Awj\Database\DatabaseManager;
use Awj\Database\Connection\Sqlite;

class DatabaseManagerTest extends TestCase
{
    /** @test
     * @throws Exception
     */
    public function it_can_add_connections_to_it()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();

        $db->addConnection($config);

        $this->assertInstanceOf(DatabaseManager::class, $db);
        $this->assertCount(1, $db->getConnections());
        $this->assertInstanceOf(Sqlite::class, $db->getConnection());
        $this->assertInstanceOf(Sqlite::class, $db->getConnection('default'));

        try {
            $db->addConnection(['type' => 'unknown', 'database' => 'unknown']);
        } catch (Exception $exception) {
            $this->assertEquals($exception->getMessage(), 'Connection type does not exist');
        }
    }

    /** @test */
    public function it_throws_an_exception_if_no_connection_is_made()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();

        try {
            $db->getConnection();
        } catch (Exception $exception) {
            $this->assertEquals($exception->getMessage(), 'Connection not found');
        }
    }

    /** @test */
    public function it_throws_an_exception_if_no_type_is_set()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();

        try {
            $db->addConnection(['database' => 'unknown']);
        } catch (Exception $exception) {
            $this->assertEquals($exception->getMessage(), 'No connection type has been set');
        }
    }

    /** @test
     * @throws Exception
     */
    public function it_can_be_made_global()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();
        $db->addConnection($config);

        $db->setAsGlobal();

        $this->assertInstanceOf(DatabaseManager::class, DatabaseManager::getInstance());
    }

    /**
     * @test
     * @runInSeparateProcess
     *
     * @throws Exception
     */
    public function it_will_fail_if_not_made_global()
    {
        $this->expectExceptionMessage('No global database manager has been initiated');
        $this->expectException(Exception::class);

        $manager = DatabaseManager::getInstance();

        $this->assertNull($manager);
    }

    /** @test
     * @throws Exception
     */
    public function it_can_get_a_connection_statically()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();
        $db
            ->addConnection($config, 'notdefault')
            ->addConnection($config);

        $db->setAsGlobal();

        $connectionA = DatabaseManager::connection('notdefault');
        $connectionB = DatabaseManager::defaultConnection();

        $this->assertInstanceOf(Sqlite::class, $connectionA);
        $this->assertInstanceOf(Sqlite::class, $connectionB);
    }

    /** @test
     * @throws Exception
     */
    public function it_can_call_a_magic_method()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();
        $db->addConnection($config);

        $db->setAsGlobal();

        $queryBuilder = DatabaseManager::newQuery();

        $this->assertInstanceOf(QueryBuilder::class, $queryBuilder);
    }

    /** @test */
    public function it_throws_an_exception_if_an_unknown_method_is_called()
    {
        $config = [
            'type'     => 'sqlite',
            'database' => ':memory:'
        ];

        $db = new DatabaseManager();

        try {
            $queryBuilder = DatabaseManager::someMethod();
        } catch (Exception $exception) {
            $this->assertEquals($exception->getMessage(), 'Method Not found');
        }
    }
}
