<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use InvalidArgumentException;

class MaxRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {
        if (empty($param[0])) {
            throw new InvalidArgumentException("Invalid argument for max rule");
        }
        $max = (int) $param[0];

        return  $data[$field]  < $max;
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $max = $param[0];
        return "This filed is must be less then $max";
    }
}
