<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Annoncescolocation;
use App\Form\CommentType;
use App\Repository\UtilisateurRepository;
use App\Repository\AnnoncescolocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment')]
class CommentController extends AbstractController
{
    private int $userid = 29; // ID de l'utilisateur, à remplacer par l'ID de l'utilisateur connecté.

    #[Route('/', name: 'app_comment_annonce')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/create/{annonceId}', name: 'app_comment_annonce_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $userRepository, AnnoncescolocationRepository $annonceRepository, int $annonceId): Response
    {
        // Créer un nouveau commentaire
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $userRepository->find($this->userid); // Remplacer par l'utilisateur connecté si nécessaire

            // Récupérer l'annonce associée
            $annonce = $annonceRepository->find($annonceId);

            // Assigner l'utilisateur et l'annonce au commentaire
            $comment->setUser($user);
            $comment->setAnnonce($annonce);
            $comment->setDateC(new \DateTime());

            // Ajouter le commentaire à l'utilisateur
            $user->addComment($comment);

            // Sauvegarder les entités
            $entityManager->persist($comment);
            $entityManager->persist($user);
            $entityManager->flush();

            // Rediriger vers la page de l'annonce
            return $this->redirectToRoute('app_annoncescolocation_show', ['id' => $annonceId]);
        }

        // Si le formulaire est invalide ou non soumis, renvoyer les erreurs
        return $this->json(['errors' => $this->getFormErrors($commentForm)], Response::HTTP_BAD_REQUEST);
    }

    // Méthode pour obtenir les erreurs de formulaire
    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[] = $error->getMessage();
        }
        return $errors;
    }
}
