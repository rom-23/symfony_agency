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
     * @param PropertyRepository $repository
     * @return Response
     */
    public function home( PropertyRepository $repository ): Response
    {
        $properties = $repository -> findLatest();
        return $this -> render( 'pages/Home.html.twig', [
            'agencies'     => $properties,
            'current_menu' => 'agencies'
        ] );
    }

}
