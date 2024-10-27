<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\OrderPlateStatus;
use App\Enum\PlateType;
use App\Repository\PlateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateRepository::class)]
class Plate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price;

    #[ORM\Column(type: Types::INTEGER, enumType: OrderPlateStatus::class)]
    private PlateType $plateType;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPlateType(): PlateType
    {
        return $this->plateType;
    }

    public function setPlateType(PlateType $plateType): void
    {
        $this->plateType = $plateType;
    }
}
