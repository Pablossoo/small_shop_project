<?php

namespace App;

interface RequestValidatorContract
{
    public function validate(array $inputParameter): bool;
}