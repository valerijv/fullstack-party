<?php

namespace App\Controller;

use App\Service\Github;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/github-login", name="github-login")
     */
    public function githubLogin(Github $github)
    {
        return $github->getClient()->redirect();
    }

    /**
     * @Route("/connect_github_check", name="connect_github_check")
     */
    public function githubCheck(Github $github)
    {
        return $github->getClient()->redirect();
    }
}
