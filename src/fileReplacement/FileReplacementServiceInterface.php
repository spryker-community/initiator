<?php

interface FileReplacementServiceInterface
{
    /**
     * @param string $oldFilePath
     * @param string $newFilePath
     *
     * @return void
     */
    public function replaceFile(string $oldFilePath, string $newFilePath): void;
}