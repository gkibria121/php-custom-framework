<?php

declare(strict_types=1);


namespace App\Library\Actions;


class FileManagerAction
{
    public function store(array $file, string $pathDir): string
    {
        $fileName = bin2hex(random_bytes(16));
        $extension = pathinfo($file['full_path'], PATHINFO_EXTENSION);
        $filePath = "$pathDir/$fileName.$extension";
        move_uploaded_file($file['tmp_name'], $filePath);
        return  "$fileName.$extension";
    }
    public function readFile(array $file)
    {
        $type = $file['mimeType'];
        header('Content-Description: File Transfer');
        header("Content-Type: $type");
        header('Content-Disposition: inline; filename="' . basename($file['name']) . '"');
        header('Content-Length: ' . filesize($file['path']));

        // Clear output buffer
        ob_clean();
        flush();

        // Send the file
        readfile($file['path']);
    }
    public function delete(array $file)
    {
        unlink($file['path']);
    }
}
