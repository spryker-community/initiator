<?php

namespace App\Command;

require_once dirname(__DIR__).'/../config/config.php';

use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $basePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        $demoShopDirectoryName = 'B2B-demo-202311';

        $wizardConfig =  [
            'sprykerDemoShopPath' => $basePath  . '..' . DIRECTORY_SEPARATOR . $demoShopDirectoryName . DIRECTORY_SEPARATOR,
            'generatedPath' => $basePath . 'generated' . DIRECTORY_SEPARATOR,
        ];

        $directory = new \RecursiveDirectoryIterator($wizardConfig['generatedPath']);
        $iterator = new \RecursiveIteratorIterator($directory);
        /** @var SplFileInfo $info */
        foreach ($iterator as $info) {
            if(in_array($info->getFilename(), ['.gitignore', '.', '..'])){
                continue;
            }

            $oldPath = $info->getPathname();
            $newPath = str_replace($wizardConfig['generatedPath'], $wizardConfig['sprykerDemoShopPath'], $info->getPathname());
            rename($oldPath, $newPath);
        }

        $output->writeln('Patching done');
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}