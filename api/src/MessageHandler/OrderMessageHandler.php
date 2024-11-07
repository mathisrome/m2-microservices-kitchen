<?php

namespace App\MessageHandler;

use App\Entity\Order;
use App\Entity\OrderPlate;
use App\Entity\Plate;
use App\Entity\User;
use App\Enum\OrderPlateStatus;
use App\Message\OrderMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class OrderMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function __invoke(OrderMessage $message): void
    {
        $order = new Order();
        $order->setUuid(new Uuid($message->uuid));
        $order->setUser($this->em->getRepository(User::class)->findOneByUuid($message->user));
        $order->setStatus(OrderPlateStatus::EN_ATTENTE);
        $order->setCreatedAt(new \DateTimeImmutable());

        foreach ($message->details as $detail) {
            for ($i = 0; $i < $detail["quantity"]; $i++) {
                $orderPlate = new OrderPlate();
                $orderPlate->setPlate($this->em->getRepository(Plate::class)->findOneByUuid($detail["plate"]));
                $orderPlate->setStatus(OrderPlateStatus::EN_ATTENTE);

                $order->addOrderPlate($orderPlate);
            }
        }

        $this->em->persist($order);
        $this->em->flush();
    }
}
