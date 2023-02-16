<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: ProSup::class)]
    private Collection $proSups;

    public function __construct()
    {
        $this->proSups = new ArrayCollection();
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
            $proSup->setSupplier($this);
        }

        return $this;
    }

    public function removeProSup(ProSup $proSup): self
    {
        if ($this->proSups->removeElement($proSup)) {
            // set the owning side to null (unless already changed)
            if ($proSup->getSupplier() === $this) {
                $proSup->setSupplier(null);
            }
        }

        return $this;
    }
}
