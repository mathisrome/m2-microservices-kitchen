<?php

namespace App\Message;

final class OrderMessage
{
    /**
     * @param string $uuid
     * @param string $user
     * @param array $details
     */
    public function __construct(
        public string $uuid,
        public string $user,
        public array $details = []
    ) {
    }
}
