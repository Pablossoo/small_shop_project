<?php

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
    private string $priceAmount;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function __construct(string $id, string $name, int $price, int $quantity)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
        $this->priceAmount = $price;
        $this->quantity = $quantity;
    }

    #[ORM\PrePersist]
    public function setCreateAt(): void
    {
        $this->createdAt = new \DateTime();
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
        return $this->priceAmount;
    }
}
