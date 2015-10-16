<?php

namespace ADH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DelegateSpecialRightType extends AbstractType {
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("add_member_right", "checkbox", array(
				"label" => "Add member",
				"required" => false
		))->add("remove_member_right", "checkbox", array(
				"label" => "Remove member",
				"required" => false
		))->add("change_status_right", "checkbox", array(
				"label" => "Change group status",
				"required" => false
		))->add("delegate_right", "checkbox", array(
				"label" => "Delegate his right",
				"required" => false
		))->add("create_child_group_right", "checkbox", array(
				"label" => "Create a child group",
				"required" => false
		))->add("add_child_group_right", "checkbox", array(
				"label" => "Add a child group",
				"required" => false
		))->add("remove_child_group_right", "checkbox", array(
				"label" => "Remove a child group",
				"required" => false
		))->add("join_parent_group_right", "checkbox", array(
				"label" => "Join a parent group",
				"required" => false
		))->add("leave_parent_group_right", "checkbox", array(
				"label" => "Leave a parent group",
				"required" => false
		))->add("rename_right", "checkbox", array(
				"label" => "Rename group",
				"required" => false
		))->add("delete_right", "checkbox", array(
				"label" => "Delete group",
				"required" => false
		))->add("special_right", "checkbox", array(
				"label" => "Special right",
				"required" => false
		))->add("update_right", "submit", array());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::configureOptions()
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
				"data_class" => "ADH\\UserBundle\\Entity\\GroupUserPermission"
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