<?php

namespace Tests\Traits;

use App\Lib\DoctrineConnection;

trait TDatabase
{
    /**
     * Set database connection
     *
     * @return void
     */
    private function setDatabaseConnection(): void
    {
        $this->doctrineEm = DoctrineConnection::getEntityManager('test');
    }

    /**
     * Initialize database
     *
     * Delete all data from the tables.
     *
     * @return void
     */
    private function initializeDatabase(): void
    {
        shell_exec(__DIR__ . '/../Scripts/initializeDatabase.sh');
    }

    
}