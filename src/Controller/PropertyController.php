<?php

namespace App\Controller;

use App\Entity\Contact2;
use App\Notification\ContactNotification;
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

    /**
     * PropertyController constructor.
     * @param PropertyRepository $repository
     * @param ObjectManager $em
     */
    public function __construct( PropertyRepository $repository, ObjectManager $em )
    {
        $this -> repository = $repository;
        $this -> em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
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
            6
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
     * @param string $slug
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response;
     */
    public function show( Property $property, string $slug, Request $request, ContactNotification $notification ): Response
    {
        if($property -> getSlug() !== $slug) {
            return $this -> redirectToRoute( 'property.show', [
                'id'   => $property -> getId(),
                'slug' => $property -> getSlug()
            ], 301 );
        }

        $contact = new Contact2();
        $contact -> setProperty( $property );
        $form = $this -> createForm( ContactType::class, $contact );
        $form -> handleRequest( $request );

        if($form -> isSubmitted() && $form -> isValid()) {
            $notification -> notify( $contact );
            $this -> addFlash( 'success', 'Email envoyé' );
             return $this -> redirectToRoute( 'property.show', [
                 'id'   => $property -> getId(),
                 'slug' => $property -> getSlug()
             ] );
        }

        return $this -> render( 'pages/agency/property-details.html.twig', [
            'property' => $property,
            'form'     => $form -> createView()
        ] );
    }
}
