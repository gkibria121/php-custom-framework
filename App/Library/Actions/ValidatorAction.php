<?php

declare(strict_types=1);


namespace App\Library\Actions;

use App\Contracts\IRule;
use Exception;

class ValidatorAction
{
    private array $rules = [];

    public function validate(array $formData, array $validationRules)
    {
        $errors = [];

        foreach ($validationRules as $field => $rules) {
            foreach ($rules as $rule) {

                if (!array_key_exists($rule, $this->rules)) {
                    throw new Exception("Rule $rule is not defined.");
                }
                $rulesInstance = $this->getRuleInstance($rule, $this->rules);
                if ($rulesInstance->validate($field, $formData, [])) {
                    continue;
                }
                $errors[$field][] = $rulesInstance->getMessage($field, $formData, []);
            }

            if (count($errors)) {
                dd($errors);
            }
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
