<?php

namespace App\Command;

use App\Logic\StoreCreator;
use App\Model\FileFromTwigBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-store',
    description: 'Creates a new Store.',
    hidden: false,
)]
class createStoreCommand extends Command
{

    public $storeCreator;
    public function __construct(StoreCreator $storeCreator, ?string $name = null)
    {
        $this->storeCreator = $storeCreator;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->storeCreator->createDeployFile();
        $this->storeCreator->createDemodata();
        $this->storeCreator->createInstallFiles();

        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}