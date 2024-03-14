<?php

namespace App\Logic;

use App\Model\FileFromTwigBuilder;
use Symfony\Component\Filesystem\Filesystem;

class StoreCreator
{
    protected FileFromTwigBuilder $fileFromTwigBuilder;
    public function __construct(FileFromTwigBuilder $fileFromTwigBuilder)
    {
        $this->fileFromTwigBuilder = $fileFromTwigBuilder;
    }

    public function createInstallFiles(array $config) {
        $regions = $config['regions'];
        $filesystem = new Filesystem();
        foreach ($regions as $region) {
            $filesystem->mkdir('generated/config/install/' . $region['regionName']);
            $this->fileFromTwigBuilder->generateTextFile(
                'config/install/REGION/production.yml.twig',
                $region,
                'config/install/' . $region['regionName'] . '/production.yml'
            );
            $this->fileFromTwigBuilder->generateTextFile(
                'config/install/REGION/pre-deploy.yml.twig',
                $region,
                'config/install/' . $region['regionName'] . '/pre-deploy.yml'
            );
            $this->fileFromTwigBuilder->generateTextFile(
                'config/install/REGION/destructive.yml.twig',
                $region,
                'config/install/' . $region['regionName'] . '/destructive.yml'
            );
        }
    }

    public function createDemodata(array $config) {
        $regions = $config['regions'];
        $filesystem = new Filesystem();
        foreach ($regions as $region) {
            $filesystem->mkdir('generated/data/import/local');
            $this->fileFromTwigBuilder->generateTextFile(
                'data/import/local/full_REGION.yml.twig',
                $region,
                'data/import/local/full_' . $region['regionName'] . '.yml'
            );
            foreach ($region['stores'] as $store) {
                $filesystem->mkdir('generated/data/import/common/' . $store['storeName'] . '/');
                $this->fileFromTwigBuilder->generateTextFile(
                    'data/import/common/STORE/STORE.yml.twig',
                    $store,
                    'data/import/common/' . $store['storeName'] . '/' . $store['storeName'] . '.yml'
                );
            }
        }
    }

    public function createDeployFile(array $config) {
        $this->fileFromTwigBuilder->generateTextFile(
            'deploy.dev.dynamic-store.yml.twig',
            $config,
            'deploy.dev.dynamic-store.yml'
        );
    }

    public function createStorePhpFile(array $config) {

    }
}