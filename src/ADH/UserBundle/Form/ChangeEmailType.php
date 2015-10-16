<?php

namespace ADH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeEmailType extends AbstractType {
	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("email", "repeated", array(
				"type" => "email",
				"invalid_message" => "email must match",
				"required" => true,
				"first_name" => "default",
				"second_name" => "confirm",
				"second_options" => array(
						"data" => ""
				)
		))->add("submit", "submit", array());
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\UserBundle\\Entity\\Form\\ChangeEmail"
		));
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("user_changeemail");
	}
}