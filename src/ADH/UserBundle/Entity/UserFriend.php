<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The user friend entity
 * 
 * (repositoryClass="ADH\UserBundle\Repository\UserFriendRepository")
 * @ORM\Entity
 * @ORM\Table(name="UserFriends")
 */
class UserFriend {
	/**
	 * The user1
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", inversedBy="friends1", fetch="EAGER")
	 * @ORM\JoinColumn(name="userId1", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\User
	 */
	private $user1;
	
	/**
	 * The user2
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", inversedBy="friends2", fetch="EAGER")
	 * @ORM\JoinColumn(name="userId2", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\User
	 */
	private $user2;
	
	/**
	 * The user1 agreement
	 *
	 * @ORM\Column(name="user1_agreement", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $user1_agreement;
	
	/**
	 * The user1 denied
	 *
	 * @ORM\Column(name="user1_denied", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $user1_denied;
	
	/**
	 * The user2 agreement
	 *
	 * @ORM\Column(name="user2_agreement", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $user2_agreement;
	
	/**
	 * The user2 denied
	 *
	 * @ORM\Column(name="user2_denied", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $user2_denied;
	
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
	 * Get the user1
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\User
	 */
	public function getUser1() {
		return ($this->user1);
	}
	
	/**
	 * Set the user1
	 * 
	 * @param User $user1
	 */
	public function setUser1(User $user1) {
		$this->user1 = $user1;
	}
	
	/**
	 * Get the user2
	 * 
	 * @return \ADH\UserBundle\Entity\ADH\UserBundle\Entity\Group
	 */
	public function getUser2() {
		return ($this->user2);
	}
	
	/**
	 * Set the user2
	 * 
	 * @param User $user2
	 */
	public function setUser2(User $user2) {
		$this->user2 = $user2;
	}
	
	/**
	 * Is user1 agree
	 * 
	 * @return boolean
	 */
	public function isUser1Agree() {
		return (!is_null($this->user1_agreement));
	}
	
	/**
	 * Set user1 agreement
	 */
	public function setUser1Agreement() {
		$this->user1_agreement = new \DateTime();
	}
	
	/**
	 * Clean user1 agreement
	 */
	public function cleanUser1Agreement() {
		$this->user1_agreement = null;
	}
	
	/**
	 * Get user1 agreement
	 * 
	 * @return DateTime
	 */
	public function getUser1Agreement() {
		return ($this->user1_agreement);
	}
	
	/**
	 * Is user1 disagree
	 * 
	 * @return boolean
	 */
	public function isUser1Disagree() {
		return (!is_null($this->user1_denied));
	}
	
	/**
	 * Set user1 denied
	 */
	public function setUser1Denied() {
		$this->user1_denied = new \DateTime();
	}
	
	/**
	 * Clean user1 denied
	 */
	public function cleanUser1Denied() {
		$this->user1_denied = null;
	}
	
	/**
	 * Get user1 denied
	 * 
	 * @return DateTime
	 */
	public function getUser1Denied() {
		return ($this->user1_denied);
	}
	
	/**
	 * Is user2 agree
	 * 
	 * @return boolean
	 */
	public function isUser2Agree() {
		return (!is_null($this->user2_agreement));
	}
	
	/**
	 * Set user2 agreement
	 */
	public function setUser2Agreement() {
		$this->user2_agreement = new \DateTime();
	}
	
	/**
	 * Clean user2 agreement
	 */
	public function cleanUser2Agreement() {
		$this->user2_agreement = null;
	}
	
	/**
	 * Get user2 agreement
	 * 
	 * @return DateTime
	 */
	public function getUser2Agreement() {
		return ($this->user2_agreement);
	}
	
	/**
	 * Is user2 disagree
	 * 
	 * @return boolean
	 */
	public function isUser2Disagree() {
		return (!is_null($this->user2_denied));
	}
	
	/**
	 * Set user2 denied
	 */
	public function setUser2Denied() {
		$this->user2_denied = new \DateTime();
	}
	
	/**
	 * Clean user2 denied
	 */
	public function cleanUser2Denied() {
		$this->user2_denied = null;
	}
	
	/**
	 * Get user2 denied
	 * 
	 * @return DateTime
	 */
	public function getUser2Denied() {
		return ($this->user2_denied);
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
}