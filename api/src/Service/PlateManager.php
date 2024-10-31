<?php

namespace App\Service;

use App\Entity\Plate;
use App\Enum\PlateType;
use App\Model\PlateDto;

class PlateManager
{
    public function entityToDto(Plate $plate): PlateDto
    {
        $dto = new PlateDTO();
        $dto->id = $plate->getId();
        $dto->name = $plate->getName();
        $dto->price = $plate->getPrice();
        $dto->plateType = $plate->getPlateType()->value;
        $dto->uuid = $plate->getUuid()->toRfc4122();

        return $dto;
    }

    public function dtoToEntity(PlateDto $dto, ?Plate $plate = null): Plate
    {
        if (empty($plate)) {
            $plate = new Plate();
        }

        $plateType = PlateType::from($dto->plateType);
        $plate->setName($dto->name);
        $plate->setPrice($dto->price);
        $plate->setPlateType($plateType);

        return $plate;
    }
}