<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class FileRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {


        return   is_uploaded_file($data[$field]['tmp_name'] ?? '');
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        return "This filed must be a file.";
    }
}
