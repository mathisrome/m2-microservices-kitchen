<?php

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\UserMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class UserMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function __invoke(UserMessage $message): void
    {
        $user = $this->em->getRepository(User::class)->findOneByUuid($message->uuid);

        if (empty($user)) {
            $user = new User();
            $user->setUuid(new Uuid($message->uuid));
        }

        $user->setEmail($message->email);
        $user->setFirstName($message->firstName);
        $user->setLastName($message->lastName);

        $this->em->persist($user);
        $this->em->flush();
    }
}
