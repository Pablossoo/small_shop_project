<?php

declare(strict_types=1);

namespace App\Exception;

class MissingParameterException extends \Exception
{
    public static function missingInputRequirementParameter(array $missingParameter): self
    {
        return new self('Request has missing parameter ' . implode(' ,', $missingParameter));
    }
}
