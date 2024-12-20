<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function listUsers(UtilisateurRepository $utilisateurRepository, Request $request): Response
    {
        $users = $utilisateurRepository->findAll();
        $editUserForm = $this->createForm(UserType::class);
        $editUserForm->handleRequest($request);

        return $this->render('admin/users.html.twig', [
            'users' => $users,
            'editUserForm' => $editUserForm->createView(),
        ]);
    }

    #[Route('/admin/user/{id}', name: 'admin_user_data', methods: ['GET'])]
    public function getUserData(UtilisateurRepository $utilisateurRepository, int $id): JsonResponse
    {
        $user = $utilisateurRepository->find($id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        return new JsonResponse([
            'nom' => $user->getNom(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'isVerified' => $user->isVerified(),
        ]);
    }
}
