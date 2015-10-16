<?php

namespace ADH\NewsBundle\Form;

use ADH\UserBundle\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatNewsType extends AbstractType {
	/**
	 * 
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("motifRefus", "text", array(
				"required" => false,
				"attr" => array(
						"placeholder" => "Motif du refus (laisser vide si inutile)"
				)
		));
		
		if ($this->user->getRoles('ROLE_ADMIN')) {
			if ($this->user->getId() == $options['data']->getAuteur()->getId()) {
				$builder->add('etat', 'choice', array(
						'choices' => array(
								0 => "Rédaction privée",
								1 => "Rédaction publique",
								2 => "Soumise pour publication",
								3 => "Publiée",
								4 => "Refusée"
						),
						'required' => true
				));
			} else {
				$builder->add('etat', 'choice', array(
						'choices' => array(
								1 => "Rédaction publique",
								2 => "Soumise pour publication",
								3 => "Publiée",
								4 => "Refusée"
						),
						'required' => true
				));
			}
		} else {
			$builder->add('etat', 'choice', array(
					'choices' => array(
							0 => "Rédaction privée",
							1 => "Rédaction publique",
							2 => "Soumise pour publication"
					),
					'required' => true
			));
		}
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
		return "adh_etatnewsType";
	}
}