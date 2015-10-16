<?php

namespace ADH\BugTrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType  extends AbstractType {
	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add("category", "entity", array(
					"required" => false,
					"class" => "ADHBugTrackerBundle:BugTrackerCategory",
					"choice_label" => "category"
			))
			->add("title", "text", array(
					"required" => true,
			))
			->add("marks", "choice", array(
					"required" => true,
					"choices" => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5
					)
			))
			->add("description", "wysiwyg", array(
					"required" => true
			))
			->add("url", "url", array(
					"required" => false,
			))
			->add("public", "checkbox", array(
					"required" => false,
					"data" => true
			))
			->add("report", "submit", array());
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\BugTrackerBundle\\Entity\\BugTrackerTicket"
		));
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("bugtracker_report");
	}
}
