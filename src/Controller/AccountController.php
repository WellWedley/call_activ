<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function editAccount(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {

     $user = $this->getUser();

        $form = $this->createForm(UserType::class,$user) ; 
        $form->handleRequest($request) ; 

        if ($form->isSubmitted() && $form->isValid()) {
    
              $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ))

                ;

            $em->persist($user);
            $em->flush();
        }
        
        return $this->render('account/index.html.twig', [
            'controller_name' => 'Mon compte',
            'form'=>$form->createView()
        ]);
    }
}
