<?php

namespace App\Controller;


use App\Form\UserType;
use App\Repository\SquadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/account', name: 'app_account')]
class AccountController extends AbstractController
{
    #[Route(path: '/', name: '_index')]
    #[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
    public function showSquads(

        SquadRepository $SquadRepository,
    ) {

        $squad = $SquadRepository
            ->findAll();


        if (!$squad) {
            throw $this->createNotFoundException('Aucune squad à afficher pour le moment');
        }

        return $this
            ->render(
                'dashboard/_show.html.twig',
                [

                    'squad' => $squad,

                ]
            );
    }



    #[Route(path: '/', name: '_edit')]
    public function editAccount(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher, #[CurrentUser] $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

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

        return $this->render('account/edit.html.twig', [
            'controller_name' => 'Mon compte',
            'form' => $form->createView()
        ]);
    }
}
