<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    private const MAX_PRODUCT_FOR_CART = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'Cart', targetEntity: ProductCart::class, orphanRemoval: true)]
    private $ProductCart;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->ProductCart = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function isFull(): bool
    {
        return $this->ProductCart->count() > self::MAX_PRODUCT_FOR_CART;
    }

    public function getTotalPrice(): int
    {
        return 1;
    }
}
