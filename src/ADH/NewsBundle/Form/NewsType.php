<?php

namespace ADH\NewsBundle\Form;

use ADH\NewsBundle\Entity\News;
use ADH\NewsBundle\Repository\NewsRepository;
use ADH\NewsBundle\Repository\CategoryNewsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType {

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
		->add("titre", "text", array(
				"attr" => array(
						"placeholder" => "Titre de la news"
				)))
		->add("source", "text", array(
				"required" => false,
				"attr" => array(
						"placeholder" => "source"
				)))
		->add("texte", "wysiwyg", array(
				"attr" => array(
						"placeholder" => "Contenu"
				)))
		->add("category", "entity", array(
				"class" => "ADHNewsBundle:CategoryNews",
				"choice_label" => "nom",
				"empty_value" => "Catégorie",
				"empty_data" => null,
				"required" => true,
				"query_builder" => function (CategoryNewsRepository $ee) {
					return $ee->createQueryBuilder("c")->orderBy("c.nom", "ASC");
				}));
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\NewsBundle\\Entity\\News"
		));
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("adh_newsType");
	}
}