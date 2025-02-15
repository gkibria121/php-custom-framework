<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class URLRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {

        return !!filter_var($data[$field], FILTER_VALIDATE_URL);
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        return "This should be a valid URL.";
    }
}
