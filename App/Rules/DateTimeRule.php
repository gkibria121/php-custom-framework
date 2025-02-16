<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use DateTime;
use InvalidArgumentException;

class DateTimeRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {
        if (empty($param[0])) {
            throw new InvalidArgumentException("Date format missing.");
        }
        $dateTime = DateTime::createFromFormat($param[0], $data[$field]);

        return $dateTime->format($param[0]) === $data[$field];
    }

    public function getMessage(string $field, array $data, array $param): string
    {

        return "This field must be numeric.";
    }
}
