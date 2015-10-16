<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The role hierarchy entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="GroupHierarchy")
 */
class GroupHierarchy {
	/**
	 * The superior
	 * 
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\Group", inversedBy="parents", fetch="EAGER")
	 * @ORM\JoinColumn(name="superior", referencedColumnName="id", onDelete="CASCADE")
	 * 
	 * @var ADH\UserBundle\Entity\Group
	 */
	private $superior;
	
	/**
	 * The subordonate
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\Group", inversedBy="children", fetch="EAGER")
	 * @ORM\JoinColumn(name="subordinate", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var ADH\UserBundle\Entity\Group
	 */
	private $subordinate;
	
	/**
	 * Get the superior
	 * 
	 * @return ADH\UserBundle\Entity\Group the superior
	 */
	public function getSuperior() {
		return ($this->superior);
	}
	
	/**
	 * Get the subordonate
	 * 
	 * @return ADH\UserBundle\Entity\Group the subordonate
	 */
	public function getSubordinate() {
		return ($this->subordinate);
	}
}