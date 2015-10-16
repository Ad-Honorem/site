<?php

namespace ADH\BetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class validerPariType extends AbstractType {

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder;
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
		return ("validerPariType");
	}
}
