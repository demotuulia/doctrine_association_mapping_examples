<?php

namespace App\Lib;

use App\Helpers\HConfig;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


class DoctrineConnection
{
    /**
     * @var null|EntityManager
     *
     */
    static private $em = null;

    /**
     * return  EntityManager
     */
    public static function getEntityManager(string $env = ''): EntityManager
    {
        if ($env == '') {
            if (isset($_GET['env'])) {
                $env = ($_GET['env']);
            }
        }

        if (self::$em === null) {
            $config = require __DIR__ . '/../../config/config.php';
            $dbConfig = $config['db'];

            $dbConfig = HConfig::getConfig('db');

            $connectionParams = [
                'dbname' => 'doctrine_association_mapping',
                'user' => 'root',
                'password' =>  'root',
                'host' => $dbConfig['host'],
                'driver' => 'pdo_mysql',
            ];

            $conn = DriverManager::getConnection($connectionParams);
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ .  '/../Entity'],
                isDevMode: true,
            );

            self::$em = new EntityManager($conn, $config);
        }
        return self::$em;
    }
}
