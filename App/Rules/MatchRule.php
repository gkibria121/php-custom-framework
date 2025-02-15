<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;

class MatchRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {

        return  $data[$field] === $data[$param[0]];
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $match = $param[0];
        return "This filed should match with \"$match\".";
    }
}
