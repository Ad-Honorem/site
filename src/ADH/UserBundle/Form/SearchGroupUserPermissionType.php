<?php

namespace ADH\UserBundle\Form;

use ADH\UserBundle\Entity\Group;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchGroupUserPermissionType extends AbstractType {
	/**
	 * The group
	 * 
	 * @var \ADH\UserBundle\Entity\Group
	 */
	private $group;
	
	/**
	 * 
	 * @param Group $group
	 */
	public function __construct(Group $group) {
		$this->group = $group;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("groupUserPermission", "entity", array(
				"class" => "ADHUserBundle:GroupUserPermission",
				"choices" => $this->group->getUserPermissions(),
				"choice_label" => "user",
				"required" => true
		));
		$builder->add("confirm", "checkbox", array(
				"required" => true
		));
		$builder->add("remove", "submit", array());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\UserBundle\\Entity\\Form\\SearchGroupUserPermission"
		));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("user_searchgroupuserpermission");
	}
}