<?php

namespace Tests;

/**
 * A base test for all tests.
 * This does some common functions for all tests
 *
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use Tests\Traits\TDatabase;
use Doctrine\ORM\EntityManager;

class BaseTest extends TestCase
{
    use TDatabase;

    /**
     * @var EntityManager
     */
    protected $doctrineEm;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->setDatabaseConnection();
        $this->initializeDatabase();
        parent::setUp();
        $this->doctrineEm->clear();
    }
}
