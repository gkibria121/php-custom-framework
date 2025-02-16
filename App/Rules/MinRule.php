<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use InvalidArgumentException;

class MinRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {
        if (empty($param[0])) {
            throw new InvalidArgumentException("Invalid argument for max rule");
        }
        $min = $param[0];
        return $data[$field] > $min;
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $min = $param[0];
        return "This filed is must be greater then $min";
    }
}
