<?php

namespace App\Controller;

use App\Entity\Discussions;
use App\Form\DiscussionsType;
use App\Repository\DiscussionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/discussions')]
final class DiscussionsController extends AbstractController
{
    #[Route(name: 'app_discussions_index', methods: ['GET'])]
    public function index(DiscussionsRepository $discussionsRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view your discussions.');
        }

        $discussions = $discussionsRepository->findByParticipant($user);
        $selectedDiscussion = null; // Define the selectedDiscussion variable

        return $this->render('discussions/index.html.twig', [
            'discussions' => $discussions,
            'selectedDiscussion' => $selectedDiscussion, // Pass the variable to the template
        ]);
    }


    #[Route('/new', name: 'app_discussions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to create a discussion.');
        }

        $discussion = new Discussions();
        $discussion->setParticipant1($user);
        $discussion->setCreatedAt(new \DateTimeImmutable());
        $discussion->setUpdatedAt(new \DateTimeImmutable());

        $form = $this->createForm(DiscussionsType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($discussion);
            $entityManager->flush();

            return $this->redirectToRoute('app_discussions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('discussions/new.html.twig', [
            'discussion' => $discussion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_discussions_show', methods: ['GET'])]
    public function show(Discussions $discussion, DiscussionsRepository $discussionsRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view this discussion.');
        }

        $discussions = $discussionsRepository->findByParticipant($user);
        $otherParticipant = $discussion->getOtherParticipant($user);

        return $this->render('messages/chat.html.twig', [
            'discussion' => $discussion,
            'otherParticipant' => $otherParticipant,
            'discussions' => $discussions, // Pass the discussions variable to the template
        ]);
    }

    #[Route('/{id}/edit', name: 'app_discussions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Discussions $discussion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DiscussionsType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_discussions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('discussions/edit.html.twig', [
            'discussion' => $discussion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_discussions_delete', methods: ['POST'])]
    public function delete(Request $request, Discussions $discussion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discussion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($discussion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_discussions_index', [], Response::HTTP_SEE_OTHER);
    }
}
