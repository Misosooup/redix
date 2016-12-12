<?php

namespace Redix\Console\Command;

use Redix\Config\Config;
use Redix\Migration\Manager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    /** @var Config */
    protected $config;

    /** @var Manager */
    private $manager;

    public function bootstrap($input, $output)
    {
        if (!$this->getConfig()) {
            $this->loadConfig($input, $output);
        }

        $this->loadManager($input, $output);
    }

    /**
     * @return Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    protected function loadConfig($input, $output)
    {
        $configFilePath = $this->locateConfigFile();

        $this->config = Config::fromYaml($configFilePath);
    }

    protected function locateConfigFile()
    {
        $configFile = 'redix.yml';

        // get the current working directory
        $cwd = getcwd();

        $locator = new FileLocator($cwd . DIRECTORY_SEPARATOR);

        return $locator->locate($configFile, $cwd, $first = true);
    }

    protected function loadManager()
    {
        if (!$this->manager) {
            $this->setManager(new Manager($this->getConfig()));
        }
    }

    protected function getManager()
    {
        return $this->manager;
    }

    protected function setManager($manager)
    {
        $this->manager = $manager;
    }
}
