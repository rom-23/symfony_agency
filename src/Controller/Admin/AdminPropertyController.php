<?php

namespace App\Controller\Admin;


use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPropertyController extends AbstractController
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
     * AdminPropertyController constructor.
     * @param PropertyRepository $repository
     * @param ObjectManager $em
     */
    public function __construct( PropertyRepository $repository, ObjectManager $em )
    {
        $this -> repository = $repository;
        $this -> em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index()
    {
        $properties = $this -> repository -> findAll();
        return $this -> render( 'admin/Property/index.html.twig', compact( 'properties' ) );
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function new( Request $request )
    {
        $property = new Property();
        $form = $this -> createForm( PropertyType::class, $property );
        $form -> handleRequest( $request );
        if($form -> isSubmitted() && $form -> isValid()) {
            $this -> em -> persist( $property );
            $this -> em -> flush();
            $this -> addFlash( 'success', 'Created with success' );
            return $this -> redirectToRoute( 'admin.property.index' );
        }
        return $this -> render( 'admin/Property/New.html.twig', [
            'property' => $property,
            'form'     => $form -> createView()
        ] );
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit( Property $property, Request $request )
    {
        $form = $this -> createForm( PropertyType::class, $property );
        $form -> handleRequest( $request );
        if($form -> isSubmitted() && $form -> isValid()) {
            $this -> em -> flush();
            $this -> addFlash( 'success', 'Updated with success' );
            return $this -> redirectToRoute( 'admin.property.index' );
        }
        return $this -> render( 'admin/Property/Edit.html.twig', [
            'property' => $property,
            'form'     => $form -> createView()
        ] );
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete( Property $property, Request $request )
    {
        if($this -> isCsrfTokenValid( 'delete' . $property -> getId(), $request -> get( '_token' ) )) {
            $this -> em -> remove( $property );
            $this -> em -> flush();
            $this -> addFlash( 'success', 'Deleted with success' );
        }
        return $this -> redirectToRoute( 'admin.property.index' );
    }
}
