<?php

namespace App\Repository;

use App\Entity\OrderPlate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderPlate>
 *
 * @method OrderPlate|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPlate|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPlate[]    findAll()
 * @method OrderPlate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPlateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderPlate::class);
    }

}