<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Repository\AnnoncesColocationRepository;
use App\Repository\LogementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogementController extends AbstractController
{
    #[Route('/logement', name: 'app_logement')]
    public function index(): Response
    {
        return $this->render('logement/index.html.twig', [
            'controller_name' => 'LogementController',
        ]);
    }

   
}
