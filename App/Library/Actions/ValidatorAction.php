<?php

declare(strict_types=1);


namespace App\Library\Actions;

use App\Contracts\IRule;
use App\Exceptions\ValidationException;
use Exception;

class ValidatorAction
{
    private array $rules = [];

    public function validate(array $formData, array $validationRules)
    {
        $errors = [];

        foreach ($validationRules as $field => $rules) {
            foreach ($rules as $rule) {
                $param = '';

                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule);
                };

                if (!array_key_exists($rule, $this->rules)) {
                    throw new Exception("Rule $rule is not defined.");
                }

                $rulesInstance = $this->getRuleInstance($rule, $this->rules);
                if ($rulesInstance->validate($field, $formData, explode(',', $param))) {
                    continue;
                }


                $errors[$field][] = $rulesInstance->getMessage($field, $formData, explode(',', $param));
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors, $formData);
        }
    }
    public function addRule(string $name, IRule $rule)
    {
        $this->rules[$name] = $rule;
    }

    private function getRuleInstance(string $id, array $rules): IRule
    {
        return   $rules[$id];
    }
}
