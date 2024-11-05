<?php

namespace App\Message;

final class PlateMessage
{
    public function __construct(
        public string $uuid,
        public string $name,
        public float  $price,
    )
    {
    }
}
