<?php

namespace App\Entity;

use App\Enum\OrderPlateStatus;
use App\Enum\PlateType;
use App\Repository\PlateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

#[ORM\Entity(repositoryClass: PlateRepository::class)]
class Plate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[NotBlank]
    #[Range(min: 1)]
    private ?float $price = null;

    #[ORM\Column(type: Types::INTEGER, enumType: PlateType::class)]
    #[NotNull]
    #[Range(min: 1, max: 3)]
    private ?PlateType $plateType = null;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPlateType(): ?PlateType
    {
        return $this->plateType;
    }

    public function setPlateType(?PlateType $plateType): void
    {
        $this->plateType = $plateType;
    }
}
