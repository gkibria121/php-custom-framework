<?php

declare(strict_types=1);


namespace App\Services;

use App\Library\Actions\ValidatorAction;
use App\Rules\Required;

class ValidationService
{
    private ValidatorAction $validator;

    public function __construct()
    {
        $this->validator = new ValidatorAction();
        $this->validator->addRule('required', new Required());
    }

    public function registrationValidate(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required']
        ]);
    }
}
