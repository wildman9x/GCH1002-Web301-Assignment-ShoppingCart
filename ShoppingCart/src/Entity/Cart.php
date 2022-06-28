<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'cart', targetEntity: Customer::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $email;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'carts')]
    private $productID;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function __construct()
    {
        $this->productID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?Customer
    {
        return $this->email;
    }

    public function setEmail(Customer $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductID(): Collection
    {
        return $this->productID;
    }

    // find a product by id
    public function getProductIDById(int $id): ?Product
    {
        foreach ($this->productID as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }

    public function addProductID(Product $productID): self
    {
        if (!$this->productID->contains($productID)) {
            $this->productID[] = $productID;
        }

        return $this;
    }

    public function removeProductID(Product $productID): self
    {
        $this->productID->removeElement($productID);

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    // increase quantity by 1
    public function addQuantity(): self
    {
        $this->quantity++;

        return $this;
    }

    // decrease quantity by 1
    public function removeQuantity(): self
    {
        $this->quantity--;

        return $this;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
