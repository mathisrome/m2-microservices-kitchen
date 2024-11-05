<?php

namespace App\Controller\Api;

use App\Entity\Plate;
use App\Message\PlateMessage;
use App\Model\PlateDto;
use App\Service\PlateManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/plates', name: 'plates_')]
class PlateController extends AbstractController
{
    #[Route('', name: 'index', methods: ["GET"])]
    public function index(
        EntityManagerInterface $em,
        PlateManager $plateManager,
    ): Response
    {
        $plates = $em->getRepository(Plate::class)->findAll();

        $plateDtos = [];

        foreach ($plates as $plate) {
            $plateDtos[] = $plateManager->entityToDto($plate);
        }

        return $this->json($plateDtos);
    }

    #[Route('', name: 'create', methods: ["POST"])]
    public function create(
        #[MapRequestPayload] PlateDto $plateDto,
        PlateManager $plateManager,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        MessageBusInterface    $messageBus
    ): JsonResponse
    {
        $plate = $plateManager->dtoToEntity($plateDto);

        $violations = $validator->validate($plate);

        if (count($violations) > 0) {
            $this->json($violations, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $em->persist($plate);
        $em->flush();

        $messageBus->dispatch(new PlateMessage(
            $plate->getUuid()->toRfc4122(),
            $plate->getName(),
            $plate->getPrice(),
        ));

        return $this->json($plateManager->entityToDto($plate));
    }

    #[Route('/{id}', name: 'update', methods: ["PUT"])]
    public function update(
        Plate $plate,
        #[MapRequestPayload] PlateDto $plateDto,
        PlateManager $plateManager,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        MessageBusInterface $messageBus
    ): JsonResponse
    {
        $plate = $plateManager->dtoToEntity($plateDto, $plate);

        $violations = $validator->validate($plate);

        if (count($violations) > 0) {
            $this->json($violations, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $em->flush();

        $messageBus->dispatch(new PlateMessage(
            $plate->getUuid()->toRfc4122(),
            $plate->getName(),
            $plate->getPrice(),
        ));

        return $this->json($plateManager->entityToDto($plate));
    }

    #[Route('/{id}', name: 'delete', methods: ["DELETE"])]
    public function delete(
        Plate $plate,
        EntityManagerInterface $em
    ): Response
    {
        $em->remove($plate);
        $em->flush();

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
