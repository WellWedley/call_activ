<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SquadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @throws \LogicException 
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException();
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param User $user
     * @param SquadController $squad
     * @param SquadRepository $squadRepository
     * @return Response
     */

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $error = 'Identifiants invalides - Veuillez réessayer';
        }

        return $this->render('security/login.html.twig',
            ['last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

}
