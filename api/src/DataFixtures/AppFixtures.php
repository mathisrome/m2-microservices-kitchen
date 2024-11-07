<?php

namespace App\DataFixtures;

use App\Entity\Plate;
use App\Enum\PlateType;
use App\Message\PlateMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $plate = new Plate();
        $plate->setName("Charcuterie");
        $plate->setPlateType(PlateType::STARTER);
        $plate->setPrice(8.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Gressins");
        $plate->setPlateType(PlateType::STARTER);
        $plate->setPrice(5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Pâtes Carbonara");
        $plate->setPlateType(PlateType::DISH);
        $plate->setPrice(15);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Pâtes Bolo");
        $plate->setPlateType(PlateType::DISH);
        $plate->setPrice(13.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Glace");
        $plate->setPlateType(PlateType::DESSERT);
        $plate->setPrice(7.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Tiramisu");
        $plate->setPlateType(PlateType::DESSERT);
        $plate->setPrice(9.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Coca-cola");
        $plate->setPlateType(PlateType::DRINK);
        $plate->setPrice(3.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $plate = new Plate();
        $plate->setName("Ice Tea");
        $plate->setPlateType(PlateType::DRINK);
        $plate->setPrice(2.5);
        $manager->persist($plate);
        $this->messageBus->dispatch(new PlateMessage(
            $plate->getUuid(),
            $plate->getName(),
            $plate->getPrice()
        ));

        $manager->flush();
    }
}
