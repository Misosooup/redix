<?php

namespace Redix\Console;

use Symfony\Component\Console\Application;
use Redix\Console\Command;

class RedixApplication extends Application
{
    public function __construct($name, $version)
    {
        parent::__construct($name, $version);

        $this->addCommands([
            new Command\Create(),
            new Command\Migrate(),
            new Command\Rollback()
        ]);
    }
}
