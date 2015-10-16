<?php

namespace ADH\BugTrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The bugtrackerstate entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="BugTrackerStates")
 */
class BugTrackerState {
	/**
	 * The default state
	 * 
	 * @var string
	 */
	const DEFAULT_STATE = "new";
	
	/**
	 * The identifier
	 * 
	 * @ORM\Id()
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * The state
	 * 
	 * @ORM\Column(name="state", type="string", length=32, nullable=false)
	 * 
	 * @var string
	 */
	private $state;
	
	/**
	 * The description
	 * 
	 * @ORM\Column(name="description", type="string", length=255, nullable=false)
	 * 
	 * @var string
	 */
	private $description;
	
	/**
	 * To string
	 * 
	 * @return string
	 */
	public function __toString() {
		return ($this->getState());
	}

	/**
	 * Get the identifier
	 * 
	 * @return int
	 */
	public function getId() {
		return ($this->id);
	}

	/**
	 * Get the state
	 * 
	 * @return string
	 */
	public function getState() {
		return ($this->state);
	}

	/**
	 * Set the state
	 * 
	 * @param string $state
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * Get the description
	 * 
	 * @return string
	 */
	public function getDescription() {
		return ($this->description);
	}

	/**
	 * Set the description
	 * 
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
}
