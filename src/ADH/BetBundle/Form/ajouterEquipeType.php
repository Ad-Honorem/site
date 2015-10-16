<?php

namespace ADH\BetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ajouterEquipeType extends AbstractType {

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('nom', 'text', array(
				'attr' => array(
						'placeholder' => "Nom de l'équipe"
				)
		))->add('poule', 'choice', array(
				'choices' => array(
						"A" => "A",
						"B" => "B",
						"C" => "C",
						"D" => "D"
				),
				'preferred_choices' => array(
						1
				),
				'empty_data' => null,
				'required' => false
		));
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\BetBundle\\Entity\\Equipe"
		));
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("ajouterEquipeType");
	}
}
