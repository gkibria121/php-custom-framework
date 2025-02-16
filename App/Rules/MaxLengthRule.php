<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use InvalidArgumentException;

class MaxLengthRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {
        if (empty($param[0])) {
            throw new InvalidArgumentException("Invalid argument for max rule");
        }
        $max = (int) $param[0];

        return  strlen($data[$field])  < $max;
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $max = $param[0];
        return "Maximum input length $max";
    }
}
