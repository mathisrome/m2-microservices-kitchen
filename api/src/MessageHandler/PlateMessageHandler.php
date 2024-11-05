<?php

namespace App\MessageHandler;

use App\Message\PlateMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PlateMessageHandler
{
    public function __invoke(PlateMessage $message): void
    {
        // do something with your message
    }
}
