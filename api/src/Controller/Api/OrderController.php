<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\OrderPlate;
use App\Entity\Plate;
use App\Enum\OrderPlateStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'get_all_orders', methods: ['GET'])]
    public function getAllOrders(EntityManagerInterface $entityManager): JsonResponse
    {
        $orders = $entityManager->getRepository(Order::class)->findAll();
        $data = [];

        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'uuid' => $order->getUuid()->toRfc4122(),
                'customer_name' => $order->getCustomerName(),
                'status' => $order->getStatus(),
                'created_at' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
                'client_id' => $order->getClientId(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/orders/{id}', name: 'get_order', methods: ['GET'])]
    public function getOrder(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $order->getId(),
            'uuid' => $order->getUuid()->toRfc4122(),
            'customer_name' => $order->getCustomerName(),
            'status' => $order->getStatus(),
            'created_at' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            'client_id' => $order->getClientId(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/orders', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request, EntityManagerInterface $entityManager): JsonResponse {

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $order = new Order();
        $order->setCustomerName($data['customer_name']);
        $order->setStatus(OrderPlateStatus::EN_ATTENTE);
        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setClientId($data['client_id']);

        $entityManager->persist($order);

        $entityManager->flush();

        $plates = $data['plates'];
        foreach ($plates as $plateData) {
            
            $plate = $entityManager->getRepository(Plate::class)->findOneBy(['name' => $plateData['name']]);
            
            if (!$plate) {
                
                $plate = new Plate();
                $plate->setName($plateData['name']);
                $plate->setPrice($plateData['price']);
                $entityManager->persist($plate);
                $entityManager->flush();
            }
            
            $orderPlate = new OrderPlate();
            $orderPlate->setOrder($order);
            $orderPlate->setPlate($plate);
            $orderPlate->setStatus(OrderPlateStatus::EN_ATTENTE);
            $entityManager->persist($orderPlate);

        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Order created successfully', 'order_id' => $order->getId()], Response::HTTP_CREATED);
    }

    #[Route('/orders/{id}', name: 'delete_order', methods: ['DELETE'])]
    public function deleteOrder(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($order);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Order deleted successfully'], Response::HTTP_OK);
    }
}
