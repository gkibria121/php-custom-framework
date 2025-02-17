<?php

declare(strict_types=1);


namespace App\Services;

use App\Library\Actions\ValidatorAction;
use App\Rules\{DateTimeRule, EmailRule, FileRule, ImageOrPdfRule, ImageRule, InRule, MatchRule, MaxLengthRule, MaxSizeRule, MinRule, NumericRule, RequiredRule, URLRule};


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
        $this->validator->addRule('maxLength', new MaxLengthRule());
        $this->validator->addRule('numeric', new NumericRule());
        $this->validator->addRule('datetime', new DateTimeRule());
        $this->validator->addRule('file', new FileRule());
        $this->validator->addRule('image', new ImageRule());
        $this->validator->addRule('imageOrPdf', new ImageOrPdfRule());
        $this->validator->addRule('maxSize', new MaxSizeRule());
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
    }
    public function loginValidate(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);
    }

    public function transactionValidate(array $formData)
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'maxLength:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'datetime:Y-m-d']

        ]);
    }

    public function   uploadReceiptValidate(array $formData)
    {

        $this->validator->validate($formData, [
            'receipt' => ['required', 'imageOrPdf', 'maxSize:10'],
        ]);
    }
}
