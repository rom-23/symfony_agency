<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     *
     */
    public function login( AuthenticationUtils $authenticationUtils )
    {
        $error = $authenticationUtils -> getLastAuthenticationError();
        $lastUsername = $authenticationUtils -> getLastUsername();
        return $this -> render( 'pages/security/Login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ] );
    }
}
