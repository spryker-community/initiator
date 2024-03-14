<?php

namespace App\Command;

use App\Logic\StoreCreator;
use App\Model\FileFromTwigBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Yaml\Yaml;

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

    protected function configure()
    {
        $this->addArgument('configPath', InputArgument::OPTIONAL, 'Configuration file path', 'project.json');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configAsJson = file_get_contents($input->getArgument('configPath'));
        $configAsArray = json_decode($configAsJson, true);
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Delete generated directory before creating new files?', true);

        if ($helper->ask($input, $output, $question)) {
            $fileSystem = new Filesystem();
            $fileSystem->remove('generated');
        }
        $this->storeCreator->createDeployFile($configAsArray);
        $this->storeCreator->createDemodata($configAsArray);
        $this->storeCreator->createInstallFiles($configAsArray);

        return Command::SUCCESS;
    }
}