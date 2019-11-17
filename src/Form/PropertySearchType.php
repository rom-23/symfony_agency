<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PropertySearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            -> add( 'minSurface', IntegerType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => 'Surface minimale'
                ]
            ] )
            -> add( 'maxPrice', IntegerType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => 'Budget maximal'
                ]
            ] )
            // ->add('submit', SubmitType::class, [
            //   'label'=> 'Rechercher'
            // ])
            -> add( 'options', EntityType::class, [
                'required'     => false,
                'label'        => false,
                'class'        => Option::class,
                'choice_label' => 'name',
                'multiple'     => true
            ] );
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver -> setDefaults( [
            'data_class'      => PropertySearch::class,
            'method'          => 'get',
            'csrf_protection' => false
        ] );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
