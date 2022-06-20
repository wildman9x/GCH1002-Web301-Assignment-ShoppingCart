<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $productID;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $catID;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $info;

    #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'productID')]
    private $carts;

    #[ORM\ManyToMany(targetEntity: OrderInfo::class, mappedBy: 'productID')]
    private $orderInfos;

    public function __construct()
    {
        $this->carts = new ArrayCollection();
        $this->orderInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductID(): ?string
    {
        return $this->productID;
    }

    public function setProductID(string $productID): self
    {
        $this->productID = $productID;

        return $this;
    }

    public function getCatID(): ?Category
    {
        return $this->catID;
    }

    public function setCatID(?Category $catID): self
    {
        $this->catID = $catID;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->addProductID($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            $cart->removeProductID($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderInfo>
     */
    public function getOrderInfos(): Collection
    {
        return $this->orderInfos;
    }

    public function addOrderInfo(OrderInfo $orderInfo): self
    {
        if (!$this->orderInfos->contains($orderInfo)) {
            $this->orderInfos[] = $orderInfo;
            $orderInfo->addProductID($this);
        }

        return $this;
    }

    public function removeOrderInfo(OrderInfo $orderInfo): self
    {
        if ($this->orderInfos->removeElement($orderInfo)) {
            $orderInfo->removeProductID($this);
        }

        return $this;
    }
}
