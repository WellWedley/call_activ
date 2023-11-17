<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SquadRepository;
use Exception;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException();
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param $user
     * @param SquadController $squad
     * @param SquadRepository $squadRepository
     *
     * @return Response
     *
     * @throws Exception
     */
    #[Route(path: '/', name: 'app_login')]
    public function login(
        AuthenticationUtils $authenticationUtils,
        #[CurrentUser] $user, SquadController $squad,
        SquadRepository $squadRepository
    ): Response {

        if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED')) {
            return $squad->showSquads($squadRepository);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

}
