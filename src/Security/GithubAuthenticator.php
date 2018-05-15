<?php

namespace App\Security;

use App\Entity\User;
use App\Service\Github;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator extends SocialAuthenticator
{
    private $em;
    private $router;
    private $github;

    public function __construct(Github $github, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
        $this->github = $github;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'connect_github_check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->github->getClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $githubUser = $this->github
            ->getClient()->fetchUserFromToken($credentials);

        $user = $this->em->getRepository(User::class)
            ->findOneBy(['githubId' => $githubUser->getId()]);
        if ($user) {
            return $user;
        } else {
            $user = new User;
            $user->setGithubId($githubUser->getId());
            $user->setUsername($githubUser->getNickname());
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse('Authentication Required', Response::HTTP_UNAUTHORIZED);
        } else {
            $url = $this->router->generate('login');
            return new RedirectResponse($url);
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('login');
        return new RedirectResponse($url);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('index');
        return new RedirectResponse($url);
    }
}