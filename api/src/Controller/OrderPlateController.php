<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\OrderPlate;
use App\Enum\OrderPlateStatus;

class OrderPlateController extends AbstractController
{
    #[Route('/orders/{order_id}/plates/{plate_id}/', name: 'update_order_plate_status', methods: ['PATCH'])]
    public function updateStatus(int $order_id, $plate_id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['status'])) {
            return new JsonResponse(['error' => 'Invalid JSON or missing parameters'], Response::HTTP_BAD_REQUEST);
        }

        $orderPlate = $entityManager->getRepository(OrderPlate::class)->findOneBy([
            'order' => $order_id,
            'plate' => $plate_id
        ]);

        if (!$orderPlate) {
            return new JsonResponse(['error' => 'OrderPlate not found'], Response::HTTP_NOT_FOUND);
        }

        try {
            $status = OrderPlateStatus::from($data['status']);
        } catch (\ValueError $e) {
            return new JsonResponse(['error' => 'Invalid status value'], Response::HTTP_BAD_REQUEST);
        }

        $orderPlate->setStatus($status);
        $entityManager->flush();

        $order = $orderPlate->getOrder();
        $allReady = true;
        $anyNotPending = false;
        foreach ($order->getOrderPlates() as $op) {
            if ($op->getStatus() !== OrderPlateStatus::PRET_A_SERVIR) {
                $allReady = false;
            }
            if ($op->getStatus() !== OrderPlateStatus::EN_ATTENTE) {
                $anyNotPending = true;
            }
        }

        if ($allReady) {
            $order->setStatus(OrderPlateStatus::PRET_A_SERVIR);
        } elseif ($anyNotPending) {
            $order->setStatus(OrderPlateStatus::EN_PREPARATION);
        } else {
            $order->setStatus(OrderPlateStatus::EN_ATTENTE);
        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Status updated successfully'], Response::HTTP_OK);
    }
}