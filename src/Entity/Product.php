<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Product implements \App\Service\Catalog\Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $price;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function __construct(string $id, string $name, int $price, int $quantity)
    {
        $this->id          = Uuid::fromString($id);
        $this->name        = $name;
        $this->price       = $price;
        $this->quantity    = $quantity;
        $this->createdAt = new \DateTime();
    }

    #[ORM\PrePersist]
    public function setCreateAt(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isStockAvailable(): bool
    {
        return $this->quantity > 0;
    }
}
