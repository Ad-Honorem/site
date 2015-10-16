<?php

namespace ADH\WYSIWYGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WYSIWYGType extends AbstractType {
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::getParent()
	 */
	public function getParent() {
		return ("textarea");
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("wysiwyg");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::buildView()
	 */
	public function buildView(FormView $view, FormInterface $form, array $options) {
		parent::buildView($view, $form, $options);
		$attr = array(
				"rows" => 8,
				"class" => "wysiwyg-editor"
		);
		if (array_key_exists("attr", $options)) {
			$attr = array_merge($attr, $options["attr"]);
		}
		
		$view->vars = array_replace($view->vars, array(
				"attr" => $attr
		));
	}
}
