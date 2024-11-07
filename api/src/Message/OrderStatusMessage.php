<?php

namespace App\Message;

final class OrderStatusMessage
{
    public function __construct(
        public string $orderUuid,
        public string $status,
    )
    {
    }
}
