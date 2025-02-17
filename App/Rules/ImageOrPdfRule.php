<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class ImageOrPdfRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {

        $mimeType = mime_content_type($data[$field]['tmp_name'] ?? '');

        return   preg_match("#(image/.+)|(application/pdf)#", $mimeType) !== 0;
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        return "This filed must be an image or a PDF.";
    }
}
