<?php

namespace Redix\Console\Command;

use Redix\Utils\Utils;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('create')
            ->setDescription('Create a new migration')
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the migration?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        $path = $this->getConfig()->getMigrationPath();

        $fileName = $this->generateFileName($input->getArgument('name'));
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName . '.php';
        if (!Utils::isFileUnique($filePath)) {
            throw new \RuntimeException(
                sprintf('The migration class name %s already exists',  $input->getArgument('name'))
            );
        }


        $migrationTemplate = $this->getConfig()->getMigrationTemplate();
        $baseClassName = 'Redix\Migration\Migration';
        $classes = [
            '$className' => ucwords(strtolower($input->getArgument('name'))),
            '$baseClassName' => $baseClassName,
        ];

        $template = strtr($migrationTemplate, $classes);

        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName . '.php', $template);
    }

    /**
     * Generate file name
     *
     * @param $name
     *
     * @return string
     */
    private function generateFileName($name)
    {
        return time() . '_' . $name;
    }
}
