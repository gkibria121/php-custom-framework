<?php

declare(strict_types=1);


namespace Framework;

use Exception;

class Template
{
    public function __construct(private string $viewsDir) {}

    public function renderView(string $viewPath, array $data = [])
    {

        $filePath = $this->getFilePath($viewPath);
        extract($data, EXTR_OVERWRITE);

        if (!file_exists($filePath)) {
            throw new Exception("Resource not found!");
        }

        ob_start();

        include  $filePath;

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
    public function resolve(string $viewPath, array $data)
    {
        extract($data);


        $filePath = $this->getFilePath($viewPath);
        try {
            include $filePath;
        } catch (Exception $e) {
            throw new Exception("Resource not found!");
        }
    }

    private function getFilePath(string $viewPath): string
    {
        if (strpos($viewPath, '.')) {
            $viewPathArr = explode('.', $viewPath);
            $viewPath = implode('/', $viewPathArr);
        }

        $filePath = $this->viewsDir . "/$viewPath.php";
        return $filePath;
    }
}
