<?php

declare(strict_types=1);


namespace App\Rules;

use App\Contracts\IRule;
use InvalidArgumentException;

class MaxSizeRule implements IRule
{
    public function validate(string $field, array $data, array $param): bool
    {
        $size =  $data[$field]['size'] ?? 0;
        if (empty($param[0])) {
            throw new InvalidArgumentException("Param is missing");
        }
        $maxSize = $param[0] * 1024 * 1024;

        return $size <= $maxSize;
    }

    public function getMessage(string $field, array $data, array $param): string
    {
        $match = $param[0];
        return "Maximum file allowed \"$match\"MB.";
    }
}
