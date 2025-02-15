<?php

declare(strict_types=1);


namespace App\Contracts;

interface IRule
{
    public function validate(string $field, array $data, array $param): bool;
    public function getMessage(string $field, array $data, array $param): string;
}
