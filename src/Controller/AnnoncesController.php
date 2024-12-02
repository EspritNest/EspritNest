<?php

namespace App\Controller;

use App\Entity\AnnoncesColocation;
use App\Form\AnnoncesColocation1Type;
use App\Repository\AnnoncesColocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annonces')]
final class AnnoncesController extends AbstractController
{
    #[Route(name: 'app_annonces_index', methods: ['GET'])]
    public function index(AnnoncesColocationRepository $annoncesColocationRepository): Response
    {
        return $this->render('annonces/index.html.twig', [
            'annonces_colocations' => $annoncesColocationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annonces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annoncesColocation = new AnnoncesColocation();
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annoncesColocation);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/new.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonces_show', methods: ['GET'])]
    public function show(AnnoncesColocation $annoncesColocation): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonces_colocation' => $annoncesColocation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnnoncesColocation $annoncesColocation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/edit.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonces_delete', methods: ['POST'])]
    public function delete(Request $request, AnnoncesColocation $annoncesColocation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncesColocation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($annoncesColocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
    }
}
