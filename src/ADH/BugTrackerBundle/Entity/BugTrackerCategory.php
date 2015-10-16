<?php

namespace ADH\BugTrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The bugtrackercategory entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="BugTrackerCategories")
 */
class BugTrackerCategory {
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
	 * The category
	 *
	 * @ORM\Column(name="category", type="string", length=32, nullable=false)
	 *
	 * @var string
	 */
	private $category;
	
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
		return ($this->getCategory());
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
	 * Get the category
	 *
	 * @return string
	 */
	public function getCategory() {
		return ($this->category);
	}
	
	/**
	 * Set the category
	 *
	 * @param string $category
	 */
	public function setCategory($category) {
		$this->category = $category;
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
