<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property")
     * @return Response;
     */
    public function index(): Response
    {
        // $property = new Property();
        // $property->setTitle('mon premier bien')
        // ->setTitle('mon premier bien')
        // ->setDescription('ma description')
        // ->setSurface(50)
        // ->setRooms(3)
        // ->setBedrooms(1)
        // ->setFloor(2)
        // ->setPrice(200000)
        // ->setCity('Paris')
        // ->setAddress('adresse 52 rue Moulin')
        // ->setPostalCode('75000');
        //
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush();
        $property = $this->repository->findAllVisible();
        dump($property);
        return $this->render('pages/Application.html.twig', [
            'properties' => $property,
            'current_menu'=>'properties'
        ]);
    }
    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response;
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
            'id'=> $property->getId(),
            'slug'=> $property->getSlug()
          ], 301);
        }
        return $this->render('pages/Show.html.twig', [
          'property' => $property
        ]);
    }
}
