<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
    public function index(): Response
    {

        $user = $this->getUser() ; 
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'user'=>$user
        ]);
    }
    
}
