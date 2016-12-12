<?php

namespace Redix\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate extends AbstractCommand
{
    public function configure()
    {
        parent::configure();

        $this->setName('migrate');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        $this->getManager()->migrate();
    }
}
