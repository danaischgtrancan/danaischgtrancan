<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptions = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?bool $forGender = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProSup::class)]
    private Collection $proSups;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProSize::class)]
    private Collection $proSizes;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->proSups = new ArrayCollection();
        $this->proSizes = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isForGender(): ?bool
    {
        return $this->forGender;
    }

    public function setForGender(bool $forGender): self
    {
        $this->forGender = $forGender;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProSup>
     */
    public function getProSups(): Collection
    {
        return $this->proSups;
    }

    public function addProSup(ProSup $proSup): self
    {
        if (!$this->proSups->contains($proSup)) {
            $this->proSups->add($proSup);
            $proSup->setProduct($this);
        }

        return $this;
    }

    public function removeProSup(ProSup $proSup): self
    {
        if ($this->proSups->removeElement($proSup)) {
            // set the owning side to null (unless already changed)
            if ($proSup->getProduct() === $this) {
                $proSup->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProSize>
     */
    public function getProSizes(): Collection
    {
        return $this->proSizes;
    }

    public function addProSize(ProSize $proSize): self
    {
        if (!$this->proSizes->contains($proSize)) {
            $this->proSizes->add($proSize);
            $proSize->setProduct($this);
        }

        return $this;
    }

    public function removeProSize(ProSize $proSize): self
    {
        if ($this->proSizes->removeElement($proSize)) {
            // set the owning side to null (unless already changed)
            if ($proSize->getProduct() === $this) {
                $proSize->setProduct(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
