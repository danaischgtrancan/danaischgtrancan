<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $voucher = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDiscount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceDicount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoucher(): ?string
    {
        return $this->voucher;
    }

    public function setVoucher(string $voucher): self
    {
        $this->voucher = $voucher;

        return $this;
    }

    public function getDateDiscount(): ?\DateTimeInterface
    {
        return $this->dateDiscount;
    }

    public function setDateDiscount(\DateTimeInterface $dateDiscount): self
    {
        $this->dateDiscount = $dateDiscount;

        return $this;
    }

    public function getPriceDicount(): ?string
    {
        return $this->priceDicount;
    }

    public function setPriceDicount(string $priceDicount): self
    {
        $this->priceDicount = $priceDicount;

        return $this;
    }
}
