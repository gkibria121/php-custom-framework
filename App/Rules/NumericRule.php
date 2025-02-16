<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use InvalidArgumentException;

class NumericRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {


        return is_numeric($data[$field]);
    }

    public function getMessage(string $field, array $data, array $param): string
    {

        return "This field must be numeric.";
    }
}
