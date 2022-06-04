<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductCartRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ProductCartRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductCart
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $Product;

    #[ORM\ManyToOne(targetEntity: Cart::class, cascade: ["persist"], inversedBy: 'productCarts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $Cart;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'ProductCart')]
    private $product;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }

    #[ORM\PrePersist]
    public function setCreateAt(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function setCart(?Cart $Cart): self
    {
        $this->Cart = $Cart;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->Cart;
    }
}
