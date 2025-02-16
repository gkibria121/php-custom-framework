<?php

declare(strict_types=1);


namespace App\Services;

use App\Library\Actions\ValidatorAction;
use App\Rules\{EmailRule, InRule, MatchRule, MinRule, RequiredRule, URLRule};


class ValidationService
{
    private ValidatorAction $validator;

    public function __construct()
    {
        $this->validator = new ValidatorAction();
        $this->validator->addRule('required', new RequiredRule());
        $this->validator->addRule('email', new EmailRule());
        $this->validator->addRule('min', new MinRule());
        $this->validator->addRule('in', new InRule());
        $this->validator->addRule('match', new MatchRule());
        $this->validator->addRule('url', new URLRule());
    }

    public function registrationValidate(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['min:8'],
            'country' => ['required', 'in:USA,Mexico,Canada'],
            'password' => ['required'],
            'confirm_password' => ['required', 'match:password'],
            'socialMediaUrl' => ['url']
        ]);
        redirectTo('/');
    }
}
