<?php

namespace App\Validator;

use App\Exception\MissingParameterException;
use App\RequestValidatorContract;

class CreateProduct implements RequestValidatorContract
{
    private const REQUIREMENTS_PARAMETER = ['name', 'price', 'quantity'];

    public function validate(array $inputParameter): bool
    {
        $missingKeys = array_diff(static::REQUIREMENTS_PARAMETER, $inputParameter);

        if (!empty($missingKeys)) {
            throw MissingParameterException::missingInputRequirementParameter($missingKeys);
        }
        return true;
    }
}