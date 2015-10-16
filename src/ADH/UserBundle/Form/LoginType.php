<?php

namespace ADH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType {
	/**
	 * The options
	 *
	 * @var array $options
	 */
	private $options;

	/**
	 * 
	 * @param array $options
	 */
	public function __construct(array $options = array()) {
		$this->options = array_merge(array(
				"reauth" => false
		), $options);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("username", ($this->options["reauth"]) ? ("hidden") : ("text"), array(
				"required" => true,
				"attr" => array(
						"placeholder" => "username"
				)));
		$builder->add("password", "password", array(
				"required" => true,
				"attr" => array(
						"placeholder" => "password"
				)));
		if (!$this->options["reauth"]) {
			$builder->add("remember_me", "checkbox", array(
					"required" => false
			));
		}
		$builder->add("login", "submit", array());
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\UserBundle\\Entity\\Form\\UserLogin"
		));
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("user_login");
	}
}