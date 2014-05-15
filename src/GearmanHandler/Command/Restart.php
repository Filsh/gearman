<?php
namespace GearmanHandler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GearmanHandler\Process;
use GearmanHandler\Config;

class Restart extends Command
{
    protected function configure()
    {
        $this->setName('restart')
            ->setDescription('Restart the gearman workers daemon')
            ->addOption('bootstrap', null, InputOption::VALUE_OPTIONAL)
            ->addOption('host', null, InputOption::VALUE_OPTIONAL)
            ->addOption('port', null, InputOption::VALUE_OPTIONAL)
            ->addOption('user', null, InputOption::VALUE_OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Stoping gearman-handler: ');

        (new Process(new Config))->stop();

        $output->write('[ <fg=green>OK</fg=green> ]', true);

        $output->write('Starting gearman-handler: ');

        $config = new Config;

        if ($bootstrap = $input->getOption('bootstrap')) {
            $config->setBootstrap($bootstrap);
        }
        if ($host = $input->getOption('host')) {
            $config->setBootstrap($host);
        }
        if ($port = $input->getOption('port')) {
            $config->setBootstrap($port);
        }
        if ($user = $input->getOption('user')) {
            $config->setBootstrap($user);
        }

        $process = new Process($config);
        if ($process->isRunning()) {
            $output->write('[ <error>Failed: Process is already runnning</error> ]', true);
            return;
        }

        if (is_file($bootstrap)) {
            require_once $bootstrap;
        }

        $output->write('[ <fg=green>OK</fg=green> ]', true);
    }
}