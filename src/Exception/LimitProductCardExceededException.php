<?php

declare(strict_types=1);

namespace App\Exception;

class LimitProductCardExceededException extends \Exception
{
    public static function LimitProductCartExceeded(string $cardId): self
    {
        return new self(sprintf('Card %s is full', $cardId));
    }
}
