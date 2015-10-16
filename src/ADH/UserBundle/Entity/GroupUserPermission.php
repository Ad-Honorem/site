<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ADH\UserBundle\Entity\User;

/**
 * The role user entity
 * 
 * @ORM\Entity(repositoryClass="ADH\UserBundle\Repository\GroupUserPermissionRepository")
 * @ORM\Table(name="GroupUserPermissions")
 */
class GroupUserPermission {
	/**
	 * The user
	 * 
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", inversedBy="groups", fetch="EAGER")
	 * @ORM\JoinColumn(name="userId", referencedColumnName="id", onDelete="CASCADE")
	 * 
	 * @var ADH\UserBundle\Entity\User
	 */
	private $user;
	
	/**
	 * The role
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\Group", inversedBy="user_permissions", fetch="EAGER")
	 * @ORM\JoinColumn(name="groupId", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\Group
	 */
	private $group;
	
	/**
	 * The officier
	 *
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", inversedBy="officierRoles")
	 * @ORM\JoinColumn(name="officier", referencedColumnName="id", onDelete="SET NULL")
	 *
	 * @var ADH\UserBundle\Entity\User|NULL
	 */
	private $officier;
	
	/**
	 * The add member right
	 *
	 * @ORM\Column(name="add_member_right", type="boolean")
	 *
	 * @var bool
	 */
	private $add_member_right;
	
	/**
	 * The remove member right
	 *
	 * @ORM\Column(name="remove_member_right", type="boolean")
	 *
	 * @var bool
	 */
	private $remove_member_right;
	
	/**
	 * The change status right
	 *
	 * @ORM\Column(name="change_status_right", type="boolean")
	 *
	 * @var bool
	 */
	private $change_status_right;
	
	/**
	 * The delegate right right
	 *
	 * @ORM\Column(name="delegate_right", type="boolean")
	 *
	 * @var bool
	 */
	private $delegate_right;
	
	/**
	 * The create child group right
	 *
	 * @ORM\Column(name="create_child_group_right", type="boolean")
	 *
	 * @var bool
	 */
	private $create_child_group_right;
	
	/**
	 * The add child group right
	 *
	 * @ORM\Column(name="add_child_group_right", type="boolean")
	 *
	 * @var bool
	 */
	private $add_child_group_right;
	
	/**
	 * The remove child group right
	 *
	 * @ORM\Column(name="remove_child_group_right", type="boolean")
	 *
	 * @var bool
	 */
	private $remove_child_group_right;
	
	/**
	 * The join parent group right
	 *
	 * @ORM\Column(name="join_parent_group_right", type="boolean")
	 *
	 * @var bool
	 */
	private $join_parent_group_right;
	
	/**
	 * The leave parent group right
	 *
	 * @ORM\Column(name="leave_parent_group_right", type="boolean")
	 *
	 * @var bool
	 */
	private $leave_parent_group_right;
	
	/**
	 * The rename right
	 *
	 * @ORM\Column(name="rename_right", type="boolean")
	 *
	 * @var bool
	 */
	private $rename_right;
	
	/**
	 * The delete right
	 *
	 * @ORM\Column(name="delete_right", type="boolean")
	 *
	 * @var bool
	 */
	private $delete_right;
	
	/**
	 * The special right
	 *
	 * @ORM\Column(name="special_right", type="boolean")
	 *
	 * @var bool
	 */
	private $special_right;
	
	/**
	 * The creation date
	 * 
	 * @ORM\Column(name="creation_date", type="datetime")
	 * 
	 * @var \DateTime
	 */
	private $creation_date;
	
	/**
	 * The modification date
	 *
	 * @ORM\Column(name="modification_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $modification_date;
	
	public function __construct() {
		$this->add_member_right = false;
		$this->remove_member_right = false;
		$this->change_status_right = false;
		$this->delegate_right = false;
		$this->create_child_group_right = false;
		$this->add_child_group_right = false;
		$this->remove_child_group_right = false;
		$this->join_parent_group_right = false;
		$this->leave_parent_group_right = false;
		$this->rename_right = false;
		$this->delete_right = false;
		$this->special_right = false;
		$this->creation_date = new \DateTime();
	}
	
	/**
	 * Get the user
	 * 
	 * @return ADH\UserBundle\Entity\User the user
	 */
	public function getUser() {
		return ($this->user);
	}

	/**
	 * Set the user
	 * 
	 * @param User $user
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}
	
	/**
	 * Get the role
	 * 
	 * @return ADH\UserBundle\Entity\Group the role
	 */
	public function getGroup() {
		return ($this->group);
	}
	
	/**
	 * Set the group
	 * 
	 * @param Group $group
	 */
	public function setGroup(Group $group) {
		$this->group = $group;
	}
	
	/**
	 * Get the officier
	 * 
	 * @return ADH\UserBundle\Entity\User|NULL the officier
	 */
	public function getOfficier() {
		return ($this->officier);
	}
	
	/**
	 * Set the officier
	 * 
	 * @param User $officier
	 */
	public function setOfficier(User $officier) {
		$this->officier = $officier;
	}

	/**
	 * Set add member right
	 * 
	 * @param bool $add_member_right
	 */
	public function setAddMemberRight($add_member_right){
		$this->add_member_right = $add_member_right;
	}
	
	/**
	 * Has add member right
	 * 
	 * @return bool
	 */
	public function hasAddMemberRight(){
		return ($this->add_member_right);
	}

	/**
	 * Set remove member right
	 * 
	 * @param bool $remove_member_right
	 */
	public function setRemoveMemberRight($remove_member_right) {
		$this->remove_member_right = $remove_member_right;
	}

	/**
	 * Has remove member right
	 *
	 * @return boolean
	 */
	public function hasRemoveMemberRight() {
		return ($this->remove_member_right);
	}

	/**
	 * Set change status right
	 *
	 * @param bool $change_status_right
	 */
	public function setChangeStatusRight($change_status_right) {
		$this->change_status_right = $change_status_right;
	}

	/**
	 * Has change status right
	 *
	 * @return boolean
	 */
	public function hasChangeStatusRight() {
		return ($this->change_status_right);
	}

	/**
	 * Set delegate right
	 *
	 * @param bool $delegate_right
	 */
	public function setDelegateRight($delegate_right) {
		$this->delegate_right = $delegate_right;
	}

	/**
	 * Has delegate right
	 *
	 * @return boolean
	 */
	public function hasDelegateRight() {
		return ($this->delegate_right);
	}

	/**
	 * Set create child group right
	 *
	 * @param bool $create_child_group_right
	 */
	public function setCreateChildGroupRight($create_child_group_right) {
		$this->create_child_group_right = $create_child_group_right;
	}

	/**
	 * Has create child group right
	 *
	 * @return boolean
	 */
	public function hasCreateChildGroupRight() {
		return ($this->create_child_group_right);
	}

	/**
	 * Set add child group right
	 *
	 * @param bool $add_child_group_right
	 */
	public function setAddChildGroupRight($add_child_group_right) {
		$this->add_child_group_right = $add_child_group_right;
	}

	/**
	 * Has add child group right
	 *
	 * @return boolean
	 */
	public function hasAddChildGroupRight() {
		return ($this->add_child_group_right);
	}

	/**
	 * Set remove child group right
	 *
	 * @param bool $remove_child_group_right
	 */
	public function setRemoveChildGroupRight($remove_child_group_right) {
		$this->remove_child_group_right = $remove_child_group_right;
	}

	/**
	 * Has remove child group right
	 *
	 * @return boolean
	 */
	public function hasRemoveChildGroupRight() {
		return ($this->remove_child_group_right);
	}

	/**
	 * Set join parent group right
	 *
	 * @param bool $join_parent_group_right
	 */
	public function setJoinParentGroupRight($join_parent_group_right) {
		$this->join_parent_group_right = $join_parent_group_right;
	}

	/**
	 * Has join parent group right
	 *
	 * @return boolean
	 */
	public function hasJoinParentGroupRight() {
		return ($this->join_parent_group_right);
	}

	/**
	 * Set leave parent group right
	 *
	 * @param bool $leave_parent_group_right
	 */
	public function setLeaveParentGroupRight($leave_parent_group_right) {
		$this->leave_parent_group_right = $leave_parent_group_right;
	}

	/**
	 * Has leave parent group right
	 *
	 * @return boolean
	 */
	public function hasLeaveParentGroupRight() {
		return ($this->leave_parent_group_right);
	}

	/**
	 * Set rename right
	 *
	 * @param bool $rename_right
	 */
	public function setRenameRight($rename_right) {
		$this->rename_right = $rename_right;
	}

	/**
	 * Has rename right
	 *
	 * @return boolean
	 */
	public function hasRenameRight() {
		return ($this->rename_right);
	}

	/**
	 * Set delete right
	 *
	 * @param bool $delete_right
	 */
	public function setDeleteRight($delete_right) {
		$this->delete_right = $delete_right;
	}

	/**
	 * Has delete right
	 *
	 * @return boolean
	 */
	public function hasDeleteRight() {
		return ($this->delete_right);
	}

	/**
	 * Set special right
	 *
	 * @param bool $special_right
	 */
	public function setSpecialRight($special_right) {
		$this->special_right = $special_right;
	}
	
	/**
	 * Has special right
	 * 
	 * @return boolean
	 */
	public function hasSpecialRight() {
		return ($this->special_right);
	}
	
	/**
	 * Get the creation date
	 * 
	 * @return \DateTime the creation date
	 */
	public function getCreationDate() {
		return ($this->creation_date);
	}
	
	/**
	 * Get the modification date
	 * 
	 * @return \DateTime the modification date
	 */
	public function getModificationDate() {
		return ($this->modification_date);
	}
}