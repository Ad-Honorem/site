<?php

namespace ADH\BetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class parierType extends AbstractType {

    /**
     * (non-PHPdoc)
     *
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //die(var_dump($options['data']->getMatch()->getEquipeA()->getNom()));
        $A = $options['data']->getMatch()->getEquipeA()->getNom();
        $B = $options['data']->getMatch()->getEquipeB()->getNom();
        $builder->add('pseudo', 'text', array(
            'attr' => array(
                'placeholder' => "Nom du parieur"
            )
        ))->add('montant', 'integer', array(
            'attr' => array(
                'placeholder' => "Montant du pari"
            )
        ))->add('resultat', 'choice', array(
            'choices' => array(
                1 => $A,
                2 => "Match Nul",
                3 => $B
            ),
            'required' => true
        ));
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Form\AbstractType::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            "data_class" => "ADH\\BetBundle\\Entity\\Pari"
        ));
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName() {
        return ("parierType");
    }

}
