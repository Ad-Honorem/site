<?php

namespace ADH\UserBundle\Entity\Form;

class SearchGroupUserPermission {
	/**
	 * The group user permission
	 * 
	 * @var \ADH\UserBundle\Entity\GroupUserPermission
	 */
	private $groupUserPermission;
	
	/**
	 * The confirm
	 * 
	 * @var bool
	 */
	private $confirm;
	
	/**
	 * Set the group user permission
	 * 
	 * @param \ADH\UserBundle\Entity\GroupUserPermission $user
	 */
	public function setGroupUserPermission($groupUserPermission) {
		$this->groupUserPermission = $groupUserPermission;
	}
	
	/**
	 * Get the group user permission
	 * 
	 * @return \ADH\UserBundle\Entity\GroupUserPermission
	 */
	public function getGroupUserPermission() {
		return ($this->groupUserPermission);
	}
	
	/**
	 * Get the confirm
	 * 
	 * @return bool
	 */
	public function getConfirm() {
		return ($this->confirm);
	}
	
	/**
	 * Is confirmed
	 * 
	 * @return boolean
	 */
	public function isConfirmed() {
		return ($this->confirm === true);
	}
	
	/**
	 * Set confirm
	 * 
	 * @param bool $confirm
	 */
	public function setConfirm($confirm) {
		$this->confirm = $confirm;
	}
}