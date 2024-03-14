<?php

namespace App\Command;

use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:patch-project',
    description: 'Patches a new Spryker Project.',
    hidden: false,
)]
class patchProjectCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('sprykerPath', InputArgument::REQUIRED, 'Spryker project file path');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $wizardConfig =  [
            'sprykerDemoShopPath' => $input->getArgument('sprykerPath'),
            'generatedPath' => 'generated' . DIRECTORY_SEPARATOR,
        ];

        $directory = new \RecursiveDirectoryIterator($wizardConfig['generatedPath']);
        $iterator = new \RecursiveIteratorIterator($directory);
        $fileSystem = new Filesystem();
        /** @var SplFileInfo $info */
        foreach ($iterator as $info) {
            if(in_array($info->getFilename(), ['.gitignore', '.', '..'])){
                continue;
            }

            $oldPath = $info->getPathname();
            $newPath = str_replace($wizardConfig['generatedPath'], $wizardConfig['sprykerDemoShopPath'], $info->getPathname());
            $fileSystem->copy($oldPath, $newPath, true);
        }

        $output->writeln('Patching done');
        return Command::SUCCESS;
    }
}