<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use App\Entity\User;
use Mailjet\Resources;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, User $user): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail()
        );

        // MAILJET API TRANSPORT //
        $_ENV['MAILER_DSN'];
        $MJ_APIKEY_PUBLIC = $_ENV['MJ_APIKEY_PUBLIC'];
        $MJ_APIKEY_PRIVATE = $_ENV['MJ_APIKEY_PRIVATE'];
        $SENDER_EMAIL = $_ENV['WEBSITE_EMAIL'];
        $RECIPIENT_EMAIL = $user->getEmail();

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "$SENDER_EMAIL",
                        'Name' => "Call-Activ'"
                    ],
                    'To' => [
                        [
                            'Email' => "$RECIPIENT_EMAIL",
                            'Name' => $user->getPrenom(),
                        ]
                    ],
                    'Subject' => "Merci de confirmer votre Email",
                    'TextPart' => "Bienvenue sur Call'Activ ",
                    'HTMLPart' => "Bonjour " . $user->getPrenom() . ", clique sur le lien ci-desous afin de vérifier ton compte. <br>
                    <a href=" . $signatureComponents->getSignedUrl() . ">Confirmer mon compte</a>"
                ]
            ]
        ];


        $mj = new \Mailjet\Client($MJ_APIKEY_PUBLIC, $MJ_APIKEY_PRIVATE, true, ['version' => 'v3.1']);
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());

    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, User $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
