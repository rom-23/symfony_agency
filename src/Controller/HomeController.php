<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     */
    public function home()
    {
        return $this -> render( 'pages/Home.html.twig' );
    }

    /**
     * @Route("/agency", name="agency")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function agency( PropertyRepository $repository ): Response
    {
        $properties = $repository -> findLatest();
        return $this -> render( 'pages/agency/Agency.html.twig', [
            'agencies'     => $properties,
            'current_menu' => 'agencies'
        ] );
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        return $this -> render( 'pages/blog/Blog.html.twig', [
            'current_menu' => 'blogs'
        ] );
    }
}
