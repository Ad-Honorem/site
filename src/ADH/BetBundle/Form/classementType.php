<?php

namespace ADH\BetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class classementType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tri', 'choice', 
                        array('choices' => array(
                            0 => 'Points', 
                            1 => 'Diff',
                            2 => 'Pris',
                            3 => 'Mis',
                            4 => 'Essais',
                            5 => 'Transformations',
                            6 => 'Pénalités',
                            7 => 'Drops',
                            8 => 'Bonus offensif',
                            9 => 'Bonus défensif'), 'required' => true))

        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'classementType';
    }

}
