<?php

namespace App\Model;

use App\Enum\PlateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class PlateDto
{
    public ?int $id = null;

    #[NotBlank]
    public ?string $name = null;
    #[NotBlank]
    #[Range(min: 1)]
    public ?float $price = null;
    #[NotNull]
    #[Range(min: 1, max: 3)]
    public ?int $plateType = null;

    public ?string $uuid = null;
}
