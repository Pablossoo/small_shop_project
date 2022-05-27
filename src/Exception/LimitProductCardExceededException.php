<?php

namespace App\Exception;

class LimitProductCardExceededException extends \Exception
{
    public static function LimitProductCartExceeded(string $cardId): self
    {
        return new self(sprintf('Limit for card %s has been reached', $cardId));
    }
}