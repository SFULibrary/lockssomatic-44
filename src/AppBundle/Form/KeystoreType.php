<?php

/*
 *  This file is licensed under the MIT License version 3 or
 *  later. See the LICENSE file for details.
 *
 *  Copyright 2018 Michael Joyce <ubermichael@gmail.com>.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Data entry form for java keystore files.
 */
class KeystoreType extends AbstractType {

    /**
     * Build the form by adding types to $builder.
     *
     * @param FormBuilderInterface $builder
     *   Form builder.
     * @param array $options
     *   Unused form options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('path', null, array(
            'label' => 'Path',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('filename', null, array(
            'label' => 'Filename',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        $builder->add('pln');
    }

    /**
     * Configure default options.
     *
     * @param OptionsResolver $resolver
     *   Options resolver to pass options back to configure the form.
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Keystore',
        ));
    }

}
