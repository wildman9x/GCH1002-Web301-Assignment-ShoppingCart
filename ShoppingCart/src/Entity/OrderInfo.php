<?php

namespace App\Entity;

use App\Repository\OrderInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderInfoRepository::class)]
class OrderInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $orderID;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'orderInfos')]
    private $productID;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'orderInfos')]
    #[ORM\JoinColumn(nullable: false)]
    private $email;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'float')]
    private $total;

    public function __construct()
    {
        $this->productID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderID(): ?string
    {
        return $this->orderID;
    }

    public function setOrderID(string $orderID): self
    {
        $this->orderID = $orderID;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductID(): Collection
    {
        return $this->productID;
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

    public function getEmail(): ?Customer
    {
        return $this->email;
    }

    public function setEmail(?Customer $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
