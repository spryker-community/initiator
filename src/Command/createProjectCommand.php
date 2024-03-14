<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:create-project',
    description: 'Creates a new Spryker Project.',
    hidden: false,
)]
class createProjectCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!is_dir('generated')) {
            mkdir('generated');
        } else {
            $filesystem = new Filesystem();
            $filesystem->remove('generated');
            mkdir('generated');
        }
        exec('git clone https://github.com/spryker-shop/b2b-demo-shop.git ./generated/');
        exec('git clone https://github.com/spryker/docker-sdk.git ./generated/docker');
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}