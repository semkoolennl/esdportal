<?php

declare(strict_types=1);

namespace App\Command\Migrations;

//use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\YamlFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DiffCommand extends Command
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct();
        $this->registry = $registry;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:migrations:diff')
            ->setDescription('Proxy to launch doctrine:migrations:diff command as it would require a "configuration" option, and we can\'t define em/connection in config.')
            ->addArgument('em', InputArgument::REQUIRED, 'Name of the Entity Manager to handle.')
//            ->addArgument('version', InputArgument::OPTIONAL, 'The version number (YYYYMMDDHHMMSS) or alias (first, prev, next, latest) to migrate to.', 'latest')
//            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Execute the migration as a dry run.')
//            ->addOption('query-time', null, InputOption::VALUE_NONE, 'Time all the queries individually.')
//            ->addOption('allow-no-migration', null, InputOption::VALUE_NONE, 'Don\'t throw an exception if no migration is available (CI).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $newInput = new ArrayInput([
//            'version'               => $input->getArgument('version'),
//            '--dry-run'             => $input->getOption('dry-run'),
//            '--query-time'          => $input->getOption('query-time'),
//            '--allow-no-migration'  => $input->getOption('allow-no-migration'),
        ]);
        $newInput->setInteractive($input->isInteractive());
        $otherCommand = new \Doctrine\Migrations\Tools\Console\Command\MigrateCommand($this->getDependencyFactory($input));
        $diffCommand = new \Doctrine\Migrations\Tools\Console\Command\DiffCommand($this->getDependencyFactory($input));
        $diffCommand->run($newInput, $output);

        return 0;
    }

    private function getDependencyFactory(InputInterface $input): DependencyFactory
    {
        $em = $this->registry->getManager($input->getArgument('em'));
        $config = new YamlFile(__DIR__ . '/../../../config/doctrine_migrations/' . $input->getArgument('em') . '.yaml');

        return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($em));
    }
}