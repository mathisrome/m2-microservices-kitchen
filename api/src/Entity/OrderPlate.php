<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderPlateRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\OrderPlateStatus;

#[ORM\Entity(repositoryClass: OrderPlateRepository::class)]
#[ApiResource]
class OrderPlate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderPlates')]
    #[ORM\JoinColumn(nullable: false)]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: Plate::class, inversedBy: 'orderPlates')]
    #[ORM\JoinColumn(nullable: false)]
    private Plate $plate;

    #[ORM\Column(type: 'string', enumType: OrderPlateStatus::class)]
    private OrderPlateStatus $status;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getPlate(): Plate
    {
        return $this->plate;
    }

    public function setPlate(Plate $plate): static
    {
        $this->plate = $plate;

        return $this;
    }

    public function getStatus(): OrderPlateStatus
    {
        return $this->status;
    }

    public function setStatus(OrderPlateStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}