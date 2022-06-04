<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Cart implements \App\Service\Cart\Cart
{
    private const MAX_PRODUCT_FOR_CART = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'Cart', targetEntity: ProductCart::class, orphanRemoval: true, cascade: (["persist"]))]
    private $productCart;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;


    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->productCart = new ArrayCollection();
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

    public function isFull(): bool
    {
        return $this->productCart->count() >= self::MAX_PRODUCT_FOR_CART;
    }

    public function getTotalPrice(): int
    {
        $total = 0;
        foreach ($this->productCart->getValues() as $value) {
            $total += $value->getProduct()->getPrice();

        }
        return $total;
    }

    public function getProducts(): array
    {
        $products = [];
        foreach ($this->productCart->getValues() as $value) {
            $products[] = $value->getProduct();
        }

        return $products;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, ProductCart>
     */
    public function getProductCart(): Collection
    {
        return $this->productCart;
    }

    public function addProductCart(ProductCart $productCart): self
    {
        if (!$this->productCart->contains($productCart)) {
            $this->productCart[] = $productCart;
            $productCart->setCart($this);
        }

        return $this;
    }

    public function removeProductCart(ProductCart $productCart): self
    {
        if ($this->productCart->removeElement($productCart)) {
            // set the owning side to null (unless already changed)
            if ($productCart->getCart() === $this) {
                $productCart->setCart(null);
            }
        }

        return $this;
    }
}
