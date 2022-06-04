<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final class Product
{
    public function __construct(
        #[NotBlank(
            normalizer: "trim"
        ),
        Length(
        min: 3
    ), Type("alnum")]
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
