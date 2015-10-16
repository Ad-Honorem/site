<?php

namespace ADH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType {

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("username", "text", array(
					"required" => true
			))->add("email", "email", array(
					"required" => true
			))->add("plaintext_password", "repeated", array(
					"type" => "password",
					"invalid_message" => "password must match",
					"required" => true,
					"first_name" => "default",
					"second_name" => "confirm"
			))->add("register", "submit", array());
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\UserBundle\Entity\User"
		));
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("user_register");
	}
}