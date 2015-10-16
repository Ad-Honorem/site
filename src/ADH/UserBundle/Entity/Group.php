<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * The role entity
 *
 * @ORM\Entity(repositoryClass="ADH\UserBundle\Repository\GroupRepository")
 * @ORM\Table(name="Groups")
 */
class Group implements RoleInterface {
	/**
	 * Default group
	 * 
	 * @var string
	 */
	const DEFAULT_GROUP = "ROLE_USER";
	
	/**
	 * The identifier
	 * 
	 * @ORM\Id()
	 * @ORM\Column(name="id", type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * The role
	 * 
	 * @ORM\Column(name="role", type="string", length=128, unique=true)
	 * 
	 * @var string
	 */
	private $role;
	
	/**
	 * The name
	 * 
	 * @ORM\Column(name="name", type="string", length=128, nullable=true)
	 * 
	 * @var string|NULL
	 */
	private $name;
	
	/**
	 * The abbreviation
	 * 
	 * @ORM\Column(name="abbreviation", type="string", length=24, nullable=true)
	 * 
	 * @var string
	 */
	private $abbreviation;
	
	/**
	 * The avatar
	 *
	 * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
	 *
	 * @var string
	 */
	private $avatar;
	
	/**
	 * The abstract
	 * 
	 * @ORM\Column(name="abstract", type="boolean")
	 * 
	 * @var bool
	 */
	private $abstract;
	
	/**
	 * The displayable
	 *
	 * @ORM\Column(name="displayable", type="boolean")
	 *
	 * @var bool
	 */
	private $displayable;
	
	/**
	 * The joinable
	 *
	 * @ORM\Column(name="joinable", type="boolean")
	 *
	 * @var bool
	 */
	private $joinable;
	
	/**
	 * The leavable
	 *
	 * @ORM\Column(name="leavable", type="boolean")
	 *
	 * @var bool
	 */
	private $leavable;
	
	/**
	 * The deletable
	 * 
	 * @ORM\Column(name="deletable", type="boolean")
	 * 
	 * @var bool
	 */
	private $deletable;
	
	/**
	 * The heritable
	 * 
	 * @ORM\Column(name="heritable", type="boolean")
	 * 
	 * @var bool
	 */
	private $heritable;
	
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
	
	/**
	 * The user permissions
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupUserPermission", mappedBy="group", fetch="EXTRA_LAZY")
	 */
	private $user_permissions;
	
	/**
	 * The superiors
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupHierarchy", mappedBy="superior", fetch="EXTRA_LAZY")
	 */
	private $parents;
	
	/**
	 * The subordinates
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupHierarchy", mappedBy="subordinate", fetch="EXTRA_LAZY")
	 */
	private $children;
	
	/**
	 * The friend1
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupHierarchyRequest", mappedBy="parent", fetch="EXTRA_LAZY")
	 */
	private $parent_request;
	
	/**
	 * The friend2
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupHierarchyRequest", mappedBy="child", fetch="EXTRA_LAZY")
	 */
	private $child_request;
	
	/**
	 * 
	 */
	public function __construct() {
		$this->creation_date = new \DateTime();
	}
	
	/**
	 * Get the identifier
	 * 
	 * @return int the identifier
	 */
	public function getId() {
		return ($this->id);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Security\Core\Role\RoleInterface::getRole()
	 */
	public function getRole() {
		return ("ROLE_" . strtoupper($this->role));
	}
	
	/**
	 * Get the short role
	 * 
	 * @return string
	 */
	public function getShortRole() {
		return ($this->role);
	}
	
	/**
	 * Set the role
	 * 
	 * @param string $role
	 */
	public function setRole($role) {
		$this->role = $role;
	}
	
	/**
	 * Get the name
	 * 
	 * @return string the name
	 */
	public function getName() {
		return ($this->name);
	}
	
	/**
	 * Set the name
	 * 
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Get the abbreviation
	 * 
	 * @return string the abbreviation
	 */
	public function getAbbreviation() {
		return ($this->abbreviation);
	}
	
	/**
	 * Set the abbreviation
	 * 
	 * @param string $abbreviation
	 */
	public function setAbbreviation($abbreviation) {
		$this->abbreviation = $abbreviation;
	}
	
	/**
	 * Has avatar
	 * 
	 * @return boolean
	 */
	public function hasAvatar() {
		return (!is_null($this->avatar));
	}
	
	/**
	 * Get the avatar
	 * 
	 * @return string
	 */
	public function getAvatar() {
		return ($this->avatar);
	}
	
	/**
	 * Set the avatar
	 * 
	 * @param string|null $avatar
	 */
	public function setAvatar($avatar) {
		$this->avatar = $avatar;
	}
	
	/**
	 * Is the group abstract
	 * 
	 * @return bool true if the role is abstract, false otherwise
	 */
	public function isAbstract() {
		return ($this->abstract);
	}
	
	/**
	 * Set the abstract
	 * 
	 * @param bool $abstract
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}
	
	/**
	 * Is the group displayable
	 * 
	 * @return boolean
	 */
	public function isDisplayable() {
		return ($this->displayable);
	}
	
	/**
	 * Set the displayable
	 * 
	 * @param bool $displayable
	 */
	public function setDisplayable($displayable) {
		$this->displayable = $displayable;
	}
	
	/**
	 * Is the group joinable
	 *
	 * @return boolean
	 */
	public function isJoinable() {
		return ($this->joinable);
	}
	
	/**
	 * Set the joinable
	 *
	 * @param bool $joinable
	 */
	public function setJoinable($joinable) {
		$this->joinable = $joinable;
	}

	/**
	 * Is the group leavable
	 *
	 * @return boolean
	 */
	public function isLeavable() {
		return ($this->leavable);
	}
	
	/**
	 * Set the leavable
	 *
	 * @param bool $leavable
	 */
	public function setLeavable($leavable) {
		$this->leavable = $leavable;
	}
	
	/**
	 * Is the group deletable
	 *
	 * @return boolean
	 */
	public function isDeletable() {
		return ($this->deletable);
	}
	
	/**
	 * Set the deletable
	 *
	 * @param bool $deletable
	 */
	public function setDeletable($deletable) {
		$this->deletable = $deletable;
	}
	
	/**
	 * Is the group heritable
	 *
	 * @return boolean
	 */
	public function isHeritable() {
		return ($this->deletable);
	}
	
	/**
	 * Set the heritable
	 *
	 * @param bool $heritable
	 */
	public function setHeritable($heritable) {
		$this->heritable = $heritable;
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
	
	/**
	 * Get the users
	 */
	public function getUserPermissions() {
		return ($this->user_permissions);
	}
	
	/**
	 * Get the superiors
	 */
	public function getParents() {
		return ($this->parents);
	}
	
	/**
	 * Get the subordinates
	 */
	public function getChildren() {
		return ($this->children);
	}
	
	/**
	 * Get parent request
	 */
	public function getParentRequest() {
		return ($this->parent_request);
	}
	
	/**
	 * Get child request
	 */
	public function getChildRequest() {
		return ($this->child_request);
	}
	
	/**
	 * Is equal to
	 * 
	 * @param Group $group
	 * @return boolean
	 */
	public function isEqualTo(Group $group) {
		return ($this->role == $group->role);
	}
}