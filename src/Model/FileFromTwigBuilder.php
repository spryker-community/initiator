<?php

namespace App\Model;

use Twig\Environment;

class FileFromTwigBuilder
{
        private $twig;

        public function __construct(Environment $twig)
        {
            $this->twig = $twig;
        }

        public function generateTextFile(string $template, array $parameters, string $filePath): void
        {
            $content = $this->twig->render($template, $parameters);

            if (!is_dir('generated')) {
                mkdir('generated');
            }
            file_put_contents('generated' . DIRECTORY_SEPARATOR . $filePath, $content);
        }


}