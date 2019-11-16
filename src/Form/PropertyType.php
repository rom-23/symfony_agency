<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            -> add( 'title' )
            -> add( 'description' )
            -> add( 'surface' )
            -> add( 'rooms' )
            -> add( 'bedrooms' )
            -> add( 'floor' )
            -> add( 'price' )
            -> add( 'options', EntityType::class, [
                'class'        => Option::class,
                'required'     => false,
                'choice_label' => 'name',
                'multiple'     => true
            ] )
            -> add( 'imageFile', FileType::class, [
                'required' => false
            ] )
            -> add( 'city' )
            -> add( 'address' )
            -> add( 'postal_code' )
            -> add( 'sold' )
            -> add( 'createdAt' );
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver -> setDefaults( [
            'data_class' => Property::class,
        ] );
    }
}
