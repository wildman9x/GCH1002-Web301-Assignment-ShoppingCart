<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'customer', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 11)]
    private $phoneNumber;

    #[ORM\OneToOne(mappedBy: 'email', targetEntity: Cart::class, cascade: ['persist', 'remove'])]
    private $cart;

    #[ORM\OneToMany(mappedBy: 'email', targetEntity: OrderInfo::class)]
    private $orderInfos;

    public function __construct()
    {
        $this->orderInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?User
    {
        return $this->email;
    }

    public function setEmail(User $email): self
    {
        $this->email = $email;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        // set the owning side of the relation if necessary
        if ($cart->getEmail() !== $this) {
            $cart->setEmail($this);
        }

        $this->cart = $cart;

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
            $orderInfo->setEmail($this);
        }

        return $this;
    }

    public function removeOrderInfo(OrderInfo $orderInfo): self
    {
        if ($this->orderInfos->removeElement($orderInfo)) {
            // set the owning side to null (unless already changed)
            if ($orderInfo->getEmail() === $this) {
                $orderInfo->setEmail(null);
            }
        }

        return $this;
    }

    // toString()
    public function __toString()
    {
        return $this->email->getEmail();
    }
}
