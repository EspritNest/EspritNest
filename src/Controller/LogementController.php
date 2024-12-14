<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Entity\Utilisateur; 
use App\Form\LogementType;
use App\Repository\LogementRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/logement')]
final class LogementController extends AbstractController
{
    
   
     #[Route(name: 'app_logement_index', methods: ['GET'])]
    public function index(LogementRepository $logementRepository): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        return $this->render('logement/index.html.twig', [
            'logements' => $logementRepository->findAll(),
            'userid' => $userid,
        ]);
    }
    #[Route(name: 'app_logement_index_ad', methods: ['GET'])]
    public function index_ad(LogementRepository $logementRepository): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        return $this->render('logement/index_admin.html.twig', [
            'logements' => $logementRepository->findAll(),
            'userid' => $userid,
        ]);
    }

    #[Route('/new', name: 'app_logement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, UtilisateurRepository $userRepository): Response
    
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
       
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $description = $form->get('Description')->getData();
           
            

            //   condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($description) {
                $originalFilename = pathinfo($description->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$description->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $description->move($this->getParameter('logement_directory'), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $logement->setDescription($newFilename);
                
                
            }
            $logement->setProprietaireId($user);

            $user->addCreatedlog($logement);


            $entityManager->persist($logement);

            $entityManager->flush();

            return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
        }

        
        return $this->render('logement/new.html.twig', [
            'logement' => $logement,
            'form' => $form,
            'userid' => $userid ,
        ]);
    }

    #[Route('/new/admin', name: 'app_logement_new_ad', methods: ['GET', 'POST'])]
    public function new_ad(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, UtilisateurRepository $userRepository): Response
    
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
       
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $description = $form->get('Description')->getData();
           
            

            //   condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($description) {
                $originalFilename = pathinfo($description->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$description->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $description->move($this->getParameter('logement_directory'), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $logement->setDescription($newFilename);
                
                
            }
            $logement->setProprietaireId($user);

            $user->addCreatedlog($logement);


            $entityManager->persist($logement);

            $entityManager->flush();

            return $this->redirectToRoute('app_logement_index_ad', [], Response::HTTP_SEE_OTHER);
        }

        
        return $this->render('logement/new_admin.html.twig', [
            'logement' => $logement,
            'form' => $form,
            'userid' => $userid ,
        ]);
    }

    #[Route('/{id}', name: 'app_logement_show', methods: ['GET'])]
    public function show(Logement $logement): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        return $this->render('logement/show.html.twig', [
            'logement' => $logement,
            'userid' => $userid,
        ]);
    }

    #[Route('/{id}/admin', name: 'app_logement_show_ad', methods: ['GET'])]
    public function show_ad(Logement $logement): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        return $this->render('logement/show_admin.html.twig', [
            'logement' => $logement,
            'userid' => $userid,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logement/edit.html.twig', [
            'logement' => $logement,
            'form' => $form,
            'userid' => $userid,
        ]);
    }

    #[Route('/{id}/edit/admin', name: 'app_logement_edit_ad', methods: ['GET', 'POST'])]
    public function edit_ad(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $user= $this->getUser();

      
        if ($user) {
          
            $userid = $user->getUserIdentifier();
        } else {
           
            $userid = null;
        }
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logement_index_ad', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logement/edit_admin.html.twig', [
            'logement' => $logement,
            'form' => $form,
            'userid' => $userid,
        ]);
    }

    #[Route('/{id}', name: 'app_logement_delete', methods: ['POST'])]
    public function delete(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/admin', name: 'app_logement_delete_ad', methods: ['POST'])]
    public function delete_ad(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logement_index_ad', [], Response::HTTP_SEE_OTHER);
    }
}
