<?php

namespace App\Controller;

use App\Service\ProfanityFilterService;
use App\Entity\AnnoncesColocation;
use App\Entity\Comment;
use App\Entity\Utilisateur;
use App\Form\AnnoncesColocation1Type;
use App\Form\CommentType;
use App\Repository\AnnoncesColocationRepository;
use App\Repository\CommentRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annonces')]
final class AnnoncesController extends AbstractController
{
    



    #[Route(name: 'app_annonces_index', methods: ['GET'])]
    public function index(AnnoncesColocationRepository $annonceRepository, Request $request): Response
    { 
        $searchQuery = $request->query->get('qb');
$sortBy = $request->query->get('sort');

// Récupère le paramètre 'type'
$type = $request->query->get('type');

// Appeler la méthode de recherche si une requête de recherche ou un type est fourni
if ($searchQuery || $type) {
    if ($type) {
        $annonces = $annonceRepository->searchByType($type); // Remplacez par la méthode spécifique pour les types d'annonces
    } else {
        $annonces = $annonceRepository->findByTitleOrDescription($searchQuery); // Rechercher dans le titre ou la description
    }
} else {
    // Si aucune recherche ou type n'est fourni, récupérer toutes les annonces
    if ($sortBy === 'date') {
        $annonces = $annonceRepository->findAllSortedByDate(); // Trier par date
    } elseif ($sortBy === 'prix') {
        $annonces = $annonceRepository->findAllSortedByPrice(); // Ajoutez cette méthode pour trier par prix
    } else {
        $annonces = $annonceRepository->findAll(); // Récupère toutes les annonces sans tri spécifique
    }
}
        return $this->render('annonces/index.html.twig', [
            'annonces_colocations' => $annonces,
            'searchQuery' => $searchQuery,
            'sortBy' => $sortBy,
            'type' => $type,
        ]);
    }
    #[Route(name: 'app_annonces_index_ad', methods: ['GET'])]
    public function index_ad(AnnoncesColocationRepository $annonceRepository, Request $request): Response
    { 
        $searchQuery = $request->query->get('qb');
$sortBy = $request->query->get('sort');

// Récupère le paramètre 'type'
$type = $request->query->get('type');

// Appeler la méthode de recherche si une requête de recherche ou un type est fourni
if ($searchQuery || $type) {
    if ($type) {
        $annonces = $annonceRepository->searchByType($type); // Remplacez par la méthode spécifique pour les types d'annonces
    } else {
        $annonces = $annonceRepository->findByTitleOrDescription($searchQuery); // Rechercher dans le titre ou la description
    }
} else {
    // Si aucune recherche ou type n'est fourni, récupérer toutes les annonces
    if ($sortBy === 'date') {
        $annonces = $annonceRepository->findAllSortedByDate(); // Trier par date
    } elseif ($sortBy === 'prix') {
        $annonces = $annonceRepository->findAllSortedByPrice(); // Ajoutez cette méthode pour trier par prix
    } else {
        $annonces = $annonceRepository->findAll(); // Récupère toutes les annonces sans tri spécifique
    }
}
        return $this->render('annonces/index_admin.html.twig', [
            'annonces_colocations' => $annonces,
            'searchQuery' => $searchQuery,
            'sortBy' => $sortBy,
            'type' => $type,
        ]);
    }

    #[Route( name: 'app_annonces_search', methods: ['GET'])]
public function search(Request $request, AnnoncesColocationRepository $annonceRepository): Response
{
    $searchQuery = $request->query->get('qb');

    // Appel de la méthode `findByTitleOrDescription` pour rechercher par titre ou description
    $annonces = $annonceRepository->findByTitleOrDescription($searchQuery);

    // Rendre les résultats dans la vue
    return $this->render('annonces/index.html.twig', [
        'annonces_colocations' => $annonces,
        'searchQuery' => $searchQuery,
        
    ]);
}
#[Route( name: 'app_annonces_search_ad', methods: ['GET'])]
public function search_ad(Request $request, AnnoncesColocationRepository $annonceRepository): Response
{
    $searchQuery = $request->query->get('qb');

    // Appel de la méthode `findByTitleOrDescription` pour rechercher par titre ou description
    $annonces = $annonceRepository->findByTitleOrDescription($searchQuery);

    // Rendre les résultats dans la vue
    return $this->render('annonces/index_admin.html.twig', [
        'annonces_colocations' => $annonces,
        'searchQuery' => $searchQuery,
        
    ]);
}


    #[Route('/new', name: 'app_annonces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,UtilisateurRepository $userRepository): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }

        $annoncesColocation = new AnnoncesColocation();
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $annoncesColocation->setUserId($user);

            $user->addCreatedann($annoncesColocation);
            $entityManager->persist($annoncesColocation);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/new.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
            'userid' => $userid
        ]);
    }

    #[Route('/new/admin', name: 'app_annonces_new_ad', methods: ['GET', 'POST'])]
    public function new_ad(Request $request, EntityManagerInterface $entityManager,UtilisateurRepository $userRepository): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }

        $annoncesColocation = new AnnoncesColocation();
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $annoncesColocation->setUserId($user);

            $user->addCreatedann($annoncesColocation);
            $entityManager->persist($annoncesColocation);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index_ad', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/new_admin.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
            'userid' => $userid
        ]);
    }


    #[Route('/{id}/comment', name: 'app_annonces_comment_create', methods: ['POST'])]
    public function createComment(
        ManagerRegistry $doctrine,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        AnnoncescolocationRepository $annoncesRepository,
        CommentRepository $commentRepository,
        UtilisateurRepository $userRepository,
        // Security $security,
        ProfanityFilterService $profanityFilterService // Inject the service
    ): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        $annonces = $annoncesRepository->findById($id);
        
    
        if (!$annonces) {
            throw $this->createNotFoundException('AnnoncesColocation not found');
        }


        

        if (!$user) {
            throw $this->createNotFoundException('user not found');
        }
       // $userId = $user->getUserIdentifier();
        
    
        $comment = new Comment();
        $comment->setAnnonce($annonces);
        $annonces->addComment($comment);
    
        $comment->setUser($user);
        $user->addComment($comment);
    
        $comment->setDateC(new \DateTime());
    
        $comments = $commentRepository->findByAnnonceId($id);
    
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
    
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Call the Profanity Filter Service
                    // Implement Bad Word Filter API
        $client = new Client();

        // Make a POST request to the Bad Word Filter API
        $response = $client->request('POST', 'https://neutrinoapi.net/bad-word-filter', [
            'form_params' => [
                'content' => $comment->getCommentt(),
                'censor-character' => '*'
            ],
            'headers' => [
                'User-Id' => '090909',
                'API-Key' => 'ZQyYo2QSkE8Q3BsFBiEpeBGU5LiDt4NKCR43SFm2vXq0Sc3Q', // Add your RapidAPI key here
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $filteredComment = json_decode($response->getBody(), true);

        // Replace the original comment content with the filtered comment
        $comment->setCommentt($filteredComment['censored-content']);

        // Persist the filtered comment to the database
        $entityManager->persist($comment);
        $entityManager->flush();
    
            // Redirect back to the annonces show page after comment creation
            return $this->redirectToRoute('app_annonces_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('annonces/show.html.twig', [
            'annonces' => $annonces,
            'users' => $annonces->getUserId(),
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),  // Assurez-vous de cette ligne
            'comment' => $comment,
        ]);
    }
    

    #[Route('/{id}', name: 'app_annonces_show', methods: ['GET'])]
    public function show(AnnoncesColocation $annoncesColocation,AnnoncesColocationRepository $ann,ManagerRegistry $doctrine,int $id, Request $request, EntityManagerInterface $entityManager,  CommentRepository $commentRepository, UtilisateurRepository $security): Response
    {
        
        // $users = $ann->getUserId();
        $comments = $commentRepository->findByAnnonceId($id);
    
        $annonces = $ann->findById($id);
                $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        
        

        $comment = new Comment();
    $commentForm = $this->createForm(CommentType::class, $comment);
    $commentForm->handleRequest($request);

    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        $entityManager->persist($comment);
        $comment->setAnnonce($annoncesColocation); // Associate the comment with the corresponding game
        $entityManager->flush();

        $this->addFlash('info', 'Comment added successfully');
         // Flash message for successful comment addition

         return $this->redirectToRoute('app_annonces_show', ['id' => $id] , Response::HTTP_SEE_OTHER);
    }
        return $this->render('annonces/show.html.twig', [
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'annonces_colocation' => $annonces,
            'userid' => $userid
        ]);
    }

    #[Route('/{id}/admin', name: 'app_annonces_show_ad', methods: ['GET'])]
    public function show_ad(AnnoncesColocation $annoncesColocation,AnnoncesColocationRepository $ann,ManagerRegistry $doctrine,int $id, Request $request, EntityManagerInterface $entityManager,  CommentRepository $commentRepository, UtilisateurRepository $security): Response
    {
        
        // $users = $ann->getUserId();
        $comments = $commentRepository->findByAnnonceId($id);
    
        $annonces = $ann->findById($id);
                $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        
        

        $comment = new Comment();
    $commentForm = $this->createForm(CommentType::class, $comment);
    $commentForm->handleRequest($request);

    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        $entityManager->persist($comment);
        $comment->setAnnonce($annoncesColocation); // Associate the comment with the corresponding game
        $entityManager->flush();

        $this->addFlash('info', 'Comment added successfully');
         // Flash message for successful comment addition

         return $this->redirectToRoute('app_annonces_show_ad', ['id' => $id] , Response::HTTP_SEE_OTHER);
    }
        return $this->render('annonces/show_admin.html.twig', [
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'annonces_colocation' => $annonces,
            'userid' => $userid
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnnoncesColocation $annoncesColocation, EntityManagerInterface $entityManager): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/edit.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
            'userid' => $userid
        ]);
    }

    #[Route('/{id}/edit/admin', name: 'app_annonces_edit_ad', methods: ['GET', 'POST'])]
    public function edit_ad(Request $request, AnnoncesColocation $annoncesColocation, EntityManagerInterface $entityManager): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        $form = $this->createForm(AnnoncesColocation1Type::class, $annoncesColocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonces_index_ad', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonces/edit_admin.html.twig', [
            'annonces_colocation' => $annoncesColocation,
            'form' => $form,
            'userid' => $userid
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

    #[Route('/{id}/admin', name: 'app_annonces_delete_ad', methods: ['POST'])]
    public function delete_ad(Request $request, AnnoncesColocation $annoncesColocation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncesColocation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($annoncesColocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonces_index_ad', [], Response::HTTP_SEE_OTHER);
    }
}
