<?php

namespace ADH\NewsBundle\Form;

use ADH\NewsBundle\Repository\CategoryNewsRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterNewsType extends AbstractType {

	/**
	 *
	 * @param FormBuilderInterface $builder 
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("category", "entity", array(
				"class" => "ADHNewsBundle:CategoryNews",
				"choice_label" => "nom",
				"empty_value" => "Toutes",
				"empty_data" => null,
				"required" => true,
				"query_builder" => function (CategoryNewsRepository $ee) {
					return $ee->createQueryBuilder("c")->orderBy("c.nom", "ASC");
				}
		));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\NewsBundle\\Entity\\Form\\FilterNews",
				"csrf_protection" => false
		));
	}

	/**
	 *
	 * @return string
	 *
	 */
	public function getName() {
		return "adh_filternewsType";
	}
}
