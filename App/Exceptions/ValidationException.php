<?php

declare(strict_types=1);



namespace App\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{

    public function __construct(public array $errors, public array $formData = [], string $message = 'Validation error!')
    {
        parent::__construct($message);
    }
}
