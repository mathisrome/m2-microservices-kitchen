<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlateController extends AbstractController
{
    #[Route('/plate', name: 'app_plate')]
    public function index(): Response
    {
        return $this->render('plate/index.html.twig', [
            'controller_name' => 'PlateController',
        ]);
    }


}
