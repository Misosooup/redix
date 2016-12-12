<?php

namespace Redix\Migration;

use Predis\Client;
use Redix\Config\Config;
use Redix\Utils\Utils;


class Manager
{
    const MIGRATE_DIRECTION_UP = 'up';

    const MIGRATE_DIRECTION_DOWN = 'down';

    const MIGRATE_REDIS_KEY = '__REDIX__';

    /** @var Config */
    private $config;

    /** @var Client */
    private $redis;

    /**
     * Manager constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->redis = new Client([
            'host' => $this->config->getHost(),
            'port' => $this->config->getPort(),
        ]);
    }

    public function migrate()
    {
        $migrations = $this->loadMigrations();
        foreach ($migrations as $migration) {
            $key = self::MIGRATE_REDIS_KEY . $migration->getFileName();

            if (!$this->redis->get($key)) {
                $migration->up();
                $this->redis->set($key, time());
            } else {
                print 'already inserted';
            }
        }
    }

    public function rollback()
    {
        $migrations = $this->loadMigrations();
        $migration = end($migrations);

        $key = self::MIGRATE_REDIS_KEY . $migration->getFileName();

        if ($this->redis->get($key)) {
            $migration->down();
            $this->redis->del([
                $key
            ]);
        }
    }

    public function loadMigrations()
    {
        $migrationPath = $this->config->getMigrationPath();

        // load Files
        $phpFiles = glob($migrationPath . DIRECTORY_SEPARATOR . '*.php');

        $migrations = [];
        foreach ($phpFiles as $phpFile) {
            require($phpFile);
            $class = Utils::mapFileNameToClassName($phpFile);
            $migrations[] = new $class();
        }

        return $migrations;
    }
}
