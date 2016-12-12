<?php

namespace Redix\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{
    /** @var string */
    private $migrationPath;

    /** @var int */
    private $port;

    /** @var string */
    private $host;

    public static function fromYaml($path)
    {
        $value = Yaml::parse(file_get_contents($path));
        return new Config($value);
    }

    /**
     * Config constructor. Load all values
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setMigrationPath($migrationPath)
    {
        $this->migrationPath = $migrationPath;
        return $this;
    }

    /**
     * Get the migration path
     * @return string
     */
    public function getMigrationPath()
    {
        return $this->migrationPath;
    }

    /**
     * @return string content of migration template
     */
    public function getMigrationTemplate()
    {
        return file_get_contents(__DIR__ . '/../Migration/Migration.template.php.dist');
    }
}
