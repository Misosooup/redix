<?php

namespace Redix\Migration;

use Predis\Client;
use Redix\Config\Config;

class Migration
{
    /** @var Client */
    public $redis;

    public function __construct()
    {
        $config = Config::fromYaml(getcwd() . DIRECTORY_SEPARATOR . 'redix.yml');
        $this->redis = new Client([
            'host' => $config->getHost(),
            'port' => $config->getPort()
        ]);
    }

    public function getFileName()
    {
        $reflectionClass = new \ReflectionClass(get_class($this));
        return basename($reflectionClass->getFileName(), '.php');
    }
}
