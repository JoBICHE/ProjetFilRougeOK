<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function accueil(): Response
    {
        // Si rôle ADMIN, on affiche le lien pour l'espace admin
     /*   if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
       {$echo = "";}
       else {
           $echo = 'none';
       } */
        return $this->render('main/accueil.html.twig', [
          /* 'echoAdmin' => $echo */
        
        ]);
        
    }

    #[Route('/boutique', name: 'boutique')]
    public function boutique(): Response
    {
        return $this->render('main/boutique.html.twig', [
            
        ]);
    }

    #[Route('/vente_privee', name: 'boutique_privee')]
    public function boutiquePrivee(): Response
    {
        return $this->render('main/boutiquePrivee.html.twig', [
            
        ]);
    }
}
