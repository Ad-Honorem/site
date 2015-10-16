<?php

namespace ADH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ADH\UserBundle\Entity\GroupUserPermission;

class DelegateBaseRightType extends AbstractType {
	/**
	 *
	 * @var bool
	 */
	private $addMemberRight = false;
	
	/**
	 * 
	 * @var bool
	 */
	private $removeMemberRight = false;
	
	/**
	 * 
	 * @var bool
	 */
	private $changeStatusRight = false;
	
	/**
	 * 
	 * @param GroupUserPermission $groupUserPermission
	 */
	public function __construct(GroupUserPermission $groupUserPermission = null) {
		if (!is_null($groupUserPermission)) {
			$this->addMemberRight = $groupUserPermission->hasAddMemberRight() || $groupUserPermission->hasSpecialRight();
			$this->removeMemberRight = $groupUserPermission->hasRemoveMemberRight() || $groupUserPermission->hasSpecialRight();
			$this->changeStatusRight = $groupUserPermission->hasChangeStatusRight() || $groupUserPermission->hasSpecialRight();
		}
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("add_member_right", "checkbox", array(
				"label" => "Add member",
				"disabled" => !$this->addMemberRight,
				"required" => false
		))->add("remove_member_right", "checkbox", array(
				"label" => "Remove member",
				"disabled" => !$this->removeMemberRight,
				"required" => false
		))->add("change_status_right", "checkbox", array(
				"label" => "Change group status",
				"disabled" => !$this->changeStatusRight,
				"required" => false
		))->add("delegate", "submit", array());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\UserBundle\\Entity\\Form\\DelegateBaseRight"
		));
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return ("user_delegatebaseright");
	}
}