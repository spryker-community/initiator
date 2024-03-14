<?php

namespace App\Logic;

use App\Model\FileFromTwigBuilder;

class StoreCreator
{
    protected FileFromTwigBuilder $fileFromTwigBuilder;
    public function __construct(FileFromTwigBuilder $fileFromTwigBuilder)
    {
        $this->fileFromTwigBuilder = $fileFromTwigBuilder;
    }

    public function createDemodata() {

    }

    public function createDeployFile() {
        $regions = [
            'EU' => [
                'regionName' => 'EU'
            ],
            'US' => [
                'regionName' => 'US'
            ],
            'PL' => [
                'regionName' => 'PL'
            ]
        ];
        $this->fileFromTwigBuilder->generateTextFile(
            'deploy.dev.dynamic-store.yml.twig',
            ['regions' => $regions],
            'deploy.dev.dynamic-store.yml'
        );
    }

    public function createStorePhpFile() {

    }
}