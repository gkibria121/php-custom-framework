<?php

declare(strict_types=1);


namespace Framework;

use Exception;
use Throwable;

class Template
{
    private array $globalData = [];
    public function __construct(private string $viewsDir) {}

    public function renderView(string $viewPath, array $data = [])
    {
        $filePath = $this->getFilePath($viewPath);
        extract($this->globalData, EXTR_OVERWRITE);
        extract($data, EXTR_OVERWRITE);

        if (!file_exists($filePath)) {
            throw new Exception("Resource not found!");
        }

        ob_start();

        try {

            include $filePath;

            $output = ob_get_clean();

            if ($output === false) {
                throw new Exception("Failed to capture the output buffer.");
            }

            return $output;
        } catch (Throwable $e) {
            ob_end_clean(); // Ensure the buffer is cleared if an exception occurs
            throw new Exception("An error occurred while rendering the view: " . $e->getMessage(), 0, $e);
        }
    }

    public function resolve(string $viewPath, array $data)
    {
        extract($this->globalData, EXTR_OVERWRITE);
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

    public function addGlobal(array $data)
    {
        $this->globalData = [...$this->globalData, ...$data];
    }
}
