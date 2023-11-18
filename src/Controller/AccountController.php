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
use App\Controller\SquadController;

#[Route('/account', name: 'app_account')]
#[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
class AccountController extends AbstractController
{

    /**
     * @param SquadRepository $SquadRepository
     * @param Currentuser     $currentUser
     * @return Response
     */
    #[Route(path: '/', name: '_index')]
    public function index(SquadController $squad, SquadRepository $squadRepository, #[CurrentUser] $currentUser): Response
    {

        $squads = $squadRepository->findBy(['user' => $currentUser], ['name' => 'DESC']);

        return $this->render('squad/show.html.twig',
            [
                'controller_name' => 'Mes Squads',
                'squads' => $squads ?: [],
            ]
        );

    }

    /**
     * @param EntityManagerInterface        $em
     * @param Request                       $request
     * @param UserPasswordHasherInterface   $userPasswordhasher
     * @param #[CurrentUser]                $user
     * 
     * @return Response
     */
    #[Route(path: '/edit', name: '_edit')]
    public function editAccount(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher, #[CurrentUser] $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $em->persist($user);
            $em->flush();
        }

        return $this->render('account/edit.html.twig', [
            'controller_name' => 'Modifier mon compte',
            'form' => $form->createView()
        ]);

    }
}
