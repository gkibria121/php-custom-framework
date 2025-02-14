<?php

declare(strict_types=1);


namespace Framework;

use Exception;

class Template
{
    public function __construct(private string $viewsDir) {}

    public function renderView(string $viewPath)
    {
        $viewPath = $this->getFilePathWithDir($viewPath);
        $filePath = $this->viewsDir . "/$viewPath.php";
        if (!file_exists($filePath)) {
            throw new Exception("Resource not found!");
        }

        ob_start();

        include  $filePath;

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    private function getFilePathWithDir(string $fileWithDir): string
    {
        if (!strpos($fileWithDir, '.')) {
            return $fileWithDir;
        }
        $viewPathArr = explode('.', $fileWithDir);
        $viewPath = implode('/', $viewPathArr);
        return $viewPath;
    }
}
