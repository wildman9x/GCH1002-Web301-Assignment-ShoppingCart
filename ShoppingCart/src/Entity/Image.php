<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $imageID;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    private $productID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageID(): ?string
    {
        return $this->imageID;
    }

    public function setImageID(string $imageID): self
    {
        if ($imageID != null) {
            $this->imageID = $imageID;
        }

        return $this;
    }

    

    public function getProductID(): ?Product
    {
        return $this->productID;
    }

    public function setProductID(?Product $productID): self
    {
        $this->productID = $productID;

        return $this;
    }
}
