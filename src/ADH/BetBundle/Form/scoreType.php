<?php

namespace ADH\BetBundle\Form;

use ADH\BetBundle\Entity\Match;
use ADH\BetBundle\Repository\MatchRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class scoreType extends AbstractType {

    /**
     * (non-PHPdoc)
     *
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('essaiA', 'integer')
                ->add('essaiB', 'integer')
                ->add('transA', 'integer')
                ->add('transB', 'integer')
                ->add('penA', 'integer')
                ->add('penB', 'integer')
                ->add('dropA', 'integer')
                ->add('dropB', 'integer');
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Form\AbstractType::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            "data_class" => "ADH\\BetBundle\\Entity\\Match"
        ));
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName() {
        return ("scoreType");
    }

}
