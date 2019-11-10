<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;

class DevHomeController extends AbstractController
{
    /**
     * @Route("/devhome", name="devhome")
     *
     */
    public function devhome()
    {
        return $this->render('pages/development/DevHome.html.twig', [
          'current_menu'=>'developments'
        ]);
    }
}
