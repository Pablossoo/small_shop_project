<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

final class Product
{
    public function __construct(
        #[NotBlank,
        Length(
        min: 3
    )]
     public readonly string $name,
        #[NotBlank,
        Positive]
     public readonly int $price,
        #[NotBlank,
        Positive]
     public readonly int $quantity
    ) {
    }
}
