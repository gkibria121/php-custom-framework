<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class InRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {

        return in_array($data[$field], $param);
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $values = join(', ', $param);
        return "This filed is must in $values";
    }
}
