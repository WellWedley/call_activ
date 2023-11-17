<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{

    /**
     * @param EmailVerifier $emailVerifier
     */
    public function __construct(private readonly EmailVerifier $emailVerifier)
    {
    }

    /**
     * @param Request                     $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface      $entityManager
     * 
     * @return Response
     */
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig',
            [
                'registrationForm' => $form->createView(),
                'controller_name' => "Inscription"
            ]);
    }

    /**
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param User $user
     *
     * @return Response
     */
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator,
        #[CurrentUser] User $user
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);

        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans(
                $exception->getReason(), [], 'VerifyEmailBundle')
            );

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse mail a été vérifiée. Connectez-vous : ');

        return $this->redirectToRoute('app_login');
    }
}
