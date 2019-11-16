<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\ContactType;

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

    public function __construct( PropertyRepository $repository, ObjectManager $em )
    {
        $this -> repository = $repository;
        $this -> em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index( PaginatorInterface $paginator, Request $request ): Response
    {
        $search = new PropertySearch();
        $form = $this -> createForm( PropertySearchType::class, $search );
        $form -> handleRequest( $request );

        $properties = $paginator -> paginate(
            $this -> repository -> findAllVisibleQuery( $search ),
            $request -> query -> getInt( 'page', 1 ),
            12
        );
        return $this -> render( 'pages/agency/index.html.twig', [
            'pagination' => $paginator,
            'properties' => $properties,
            'form'       => $form -> createView()
        ] );
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response;
     */
    public function show( Property $property, string $slug, Request $request ): Response
    {
        if($property -> getSlug() !== $slug) {
            return $this -> redirectToRoute( 'property.show', [
                'id'   => $property -> getId(),
                'slug' => $property -> getSlug()
            ], 301 );
        }

        $contact = new Contact();
        $contact -> setProperty( $property );
        $form = $this -> createForm( ContactType::class, $contact );
        $form -> handleRequest( $request );

        if($form -> isSubmitted() && $form -> isValid()) {
            $this -> addFlash( 'success', 'Email envoyé' );
            return $this -> redirectToRoute( 'property.show', [
                'id'   => $property -> getId(),
                'slug' => $property -> getSlug()
            ] );
        }

        return $this -> render( 'pages/agency/Show.html.twig', [
            'property' => $property,
            'form'     => $form -> createView()
        ] );
    }
}
