<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        $request->getSession()->getFlashBag()->add(
            'note', 'Vous devez être connecté pour accéder à cette page.'
        );

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
