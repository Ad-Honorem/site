<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The group hierarchy request entity
 * 
 * @ORM\Entity(repositoryClass="ADH\UserBundle\Repository\GroupHierarchyRequestRepository")
 * @ORM\Table(name="GroupHierarchyRequests")
 */
class GroupHierarchyRequest {
	/**
	 * The parent
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\Group", inversedBy="parent_request", fetch="EAGER")
	 * @ORM\JoinColumn(name="parentId", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\Group
	 */
	private $parent;
	
	/**
	 * The child
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\Group", inversedBy="child_request", fetch="EAGER")
	 * @ORM\JoinColumn(name="childId", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\Group
	 */
	private $child;
	
	/**
	 * The parent agreement
	 *
	 * @ORM\Column(name="parent_agreement", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $parent_agreement;
	
	/**
	 * The parent denied
	 *
	 * @ORM\Column(name="parent_denied", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $parent_denied;
	
	/**
	 * The child agreement
	 *
	 * @ORM\Column(name="child_agreement", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $child_agreement;
	
	/**
	 * The child denied
	 *
	 * @ORM\Column(name="child_denied", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $child_denied;
	
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
	 * Get the parent
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\User
	 */
	public function getParent() {
		return ($this->parent);
	}
	
	/**
	 * Set the parent
	 * 
	 * @param User $parent
	 */
	public function setParent(Group $parent) {
		$this->parent = $parent;
	}
	
	/**
	 * Get the child
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\Group
	 */
	public function getChild() {
		return ($this->child);
	}
	
	/**
	 * Set the child
	 * 
	 * @param User $child
	 */
	public function setChild(Group $child) {
		$this->child = $child;
	}
	
	/**
	 * Is parent agree
	 * 
	 * @return boolean
	 */
	public function isParentAgree() {
		return (!is_null($this->parent_agreement));
	}
	
	/**
	 * Set parent agreement
	 */
	public function setParentAgreement() {
		$this->parent_agreement = new \DateTime();
	}
	
	/**
	 * Clean parent agreement
	 */
	public function cleanParentAgreement() {
		$this->parent_agreement = null;
	}
	
	/**
	 * Get parent agreement
	 * 
	 * @return DateTime
	 */
	public function getParentAgreement() {
		return ($this->parent_agreement);
	}
	
	/**
	 * Is parent disagree
	 * 
	 * @return boolean
	 */
	public function isParentDisagree() {
		return (!is_null($this->parent_denied));
	}
	
	/**
	 * Set parent denied
	 */
	public function setParentDenied() {
		$this->parent_denied = new \DateTime();
	}
	
	/**
	 * Clean parent denied
	 */
	public function cleanParentDenied() {
		$this->parent_denied = null;
	}
	
	/**
	 * Get parent denied
	 * 
	 * @return DateTime
	 */
	public function getParentDenied() {
		return ($this->parent_denied);
	}
	
	/**
	 * Is child agree
	 * 
	 * @return boolean
	 */
	public function isChildAgree() {
		return (!is_null($this->child_agreement));
	}
	
	/**
	 * Set child agreement
	 */
	public function setChildAgreement() {
		$this->child_agreement = new \DateTime();
	}
	
	/**
	 * Clean child agreement
	 */
	public function cleanChildAgreement() {
		$this->child_agreement = null;
	}
	
	/**
	 * Get child agreement
	 * 
	 * @return DateTime
	 */
	public function getChildAgreement() {
		return ($this->child_agreement);
	}
	
	/**
	 * Is child disagree
	 * 
	 * @return boolean
	 */
	public function isChildDisagree() {
		return (!is_null($this->child_denied));
	}
	
	/**
	 * Set child denied
	 */
	public function setChildDenied() {
		$this->child_denied = new \DateTime();
	}
	
	/**
	 * Clean child denied
	 */
	public function cleanChildDenied() {
		$this->child_denied = null;
	}
	
	/**
	 * Get child denied
	 * 
	 * @return DateTime
	 */
	public function getChildDenied() {
		return ($this->child_denied);
	}
	
	/**
	 * Get the creation date
	 * 
	 * @return DateTime
	 */
	public function getCreationDate() {
		return ($this->creation_date);
	}
	
	/**
	 * Get the modification date
	 * 
	 * @return DateTime
	 */
	public function getModificationDate() {
		return ($this->modification_date);
	}
	
	/**
	 * Get from
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\Group
	 */
	public function getFrom() {
		return (($this->isChildAgree() && !$this->isParentAgree()) ? ($this->child) : ($this->parent));
	}
	
	/**
	 * Get to
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\Group
	 */
	public function getTo() {
		return (($this->isChildAgree() && !$this->isParentAgree()) ? ($this->parent) : ($this->child));
	}
	
	/**
	 * Is join request
	 * 
	 * @return boolean
	 */
	public function isJoinRequest() {
		return ($this->isChildAgree() && !$this->isParentAgree());
	}
	
	/**
	 * Is invitation request
	 * 
	 * @return boolean
	 */
	public function isInvitationRequest() {
		return ($this->isParentAgree() && !$this->isChildAgree());
	}
}