<?php

namespace App\Form;

use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            -> add( 'name' );
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver -> setDefaults( [
            'data_class' => Option::class,
        ] );
    }
}
