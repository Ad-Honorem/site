<?php

namespace ADH\BetBundle\Form;

use ADH\BetBundle\Entity\Equipe;
use ADH\BetBundle\Repository\EquipeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ajouterMatchType extends AbstractType {

    /**
     * (non-PHPdoc)
     *
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('equipeA', 'entity', array(
            'class' => 'ADHBetBundle:Equipe',
            'property' => 'nom',
            'empty_value' => 'Equipe A',
            'empty_data' => null,
            'required' => true,
            'query_builder' => function (EquipeRepository $ee) {
                return $ee->createQueryBuilder('e')->orderBy('e.poule', 'ASC')->addOrderBy('e.nom', 'ASC');
            }
        ))->add('equipeB', 'entity', array(
            'class' => 'ADHBetBundle:Equipe',
            'property' => 'nom',
            'empty_value' => 'Equipe B',
            'empty_data' => null,
            'required' => true,
            'query_builder' => function (EquipeRepository $ee) {
                return $ee->createQueryBuilder('e')->orderBy('e.poule', 'ASC')->addOrderBy('e.nom', 'ASC');
            }
        ))->add('ladate', 'date', array(
            'label' => "Date du match : ",
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy HH:mm',
            'attr' => array(
                'class' => 'date form-control'
            )
        ))->add('type', 'choice', array(
            'choices' => array(
                "poule" => "Poule",
                "1/4" => "Quart de finale",
                "1/2" => "Demie finale",
                "Petite finale" => "Petite finale",
                "Finale" => "Finale",
            ),
            'preferred_choices' => array(
                1
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
            "data_class" => "ADH\\BetBundle\\Entity\\match"
        ));
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName() {
        return ("ajouterMatchType");
    }

}
