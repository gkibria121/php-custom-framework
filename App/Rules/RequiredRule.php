<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class RequiredRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {

        return isset($data[$field]);
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        return "This filed is required.";
    }
}
