<?php

namespace ADH\UserBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;
use ADH\UserBundle\Entity\GroupUserPermission;

class DelegateBaseRight {
	/**
	 * Add member right
	 *
	 * @var bool
	 */
	private $addMemberRight;
	
	/**
	 * Remove member right
	 *
	 * @var bool
	 */
	private $removeMemberRight;
	
	/**
	 * change status right
	 *
	 * @var bool
	 */
	private $changeStatusRight;
	
	/**
	 * 
	 * @param GroupUserPermission $permission
	 */
	public function __construct(GroupUserPermission $permission = null) {
		$this->setAddMemberRight($permission->hasAddMemberRight());
		$this->setRemoveMemberRight($permission->hasRemoveMemberRight());
		$this->setChangeStatusRight($permission->hasChangeStatusRight());
	}

	/**
	 * Set add member right
	 *
	 * @param bool $addMemberRight 
	 */
	public function setAddMemberRight($addMemberRight) {
		$this->addMemberRight = $addMemberRight;
	}

	/**
	 * Has add member right
	 *
	 * @return boolean
	 */
	public function hasAddMemberRight() {
		return ($this->addMemberRight);
	}

	/**
	 * Set remove member right
	 *
	 * @param bool $removeMemberRight 
	 */
	public function setRemoveMemberRight($removeMemberRight) {
		$this->removeMemberRight = $removeMemberRight;
	}

	/**
	 * Has remove member right
	 *
	 * @return boolean
	 */
	public function hasRemoveMemberRight() {
		return ($this->removeMemberRight);
	}

	/**
	 * Set change status right
	 *
	 * @param bool $changeStatusRight 
	 */
	public function setChangeStatusRight($changeStatusRight) {
		$this->changeStatusRight = $changeStatusRight;
	}

	/**
	 * Has change status right
	 *
	 * @return boolean
	 */
	public function hasChangeStatusRight() {
		return ($this->changeStatusRight);
	}
}