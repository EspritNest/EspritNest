<?php

namespace App\Controller;

use App\Entity\Trajets;
use App\Form\TrajetsType;
use App\Repository\TrajetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/trajets')]
final class TrajetsController extends AbstractController
{
    #[Route(name: 'app_trajets_index', methods: ['GET'])]
    public function index(TrajetsRepository $trajetsRepository): Response
    {
        return $this->render('trajets/index.html.twig', [
            'trajets' => $trajetsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trajets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trajet = new Trajets();
        $form = $this->createForm(TrajetsType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trajet);
            $entityManager->flush();

            return $this->redirectToRoute('app_trajets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trajets/new.html.twig', [
            'trajet' => $trajet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trajets_show', methods: ['GET'])]
    public function show(Trajets $trajet): Response
    {
        return $this->render('trajets/show.html.twig', [
            'trajet' => $trajet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trajets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trajets $trajet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrajetsType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trajets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trajets/edit.html.twig', [
            'trajet' => $trajet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trajets_delete', methods: ['POST'])]
    public function delete(Request $request, Trajets $trajet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trajet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trajet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trajets_index', [], Response::HTTP_SEE_OTHER);
    }
}
