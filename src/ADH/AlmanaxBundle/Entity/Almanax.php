<?php

namespace ADH\AlmanaxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The team entity
 *
 * @ORM\Entity(repositoryClass="ADH\AlmanaxBundle\Repository\AlmanaxRepository")
 * @ORM\Table(name="Almanax")
 */
class Almanax {
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
	 *The date
	 *
	 * @ORM\Column(name="date", type="date")
	 *
	 * @var \DateTime $date
	 */
	private $date;
	
	/**
	 * The quantity
	 *
	 * @ORM\Column(name="quantity", type="integer")
	 *
	 * @var int
	 */
	private $quantity;
	
	/**
	 * The object
	 *
	 * @ORM\Column(name="object", type="string", length=255)
	 *
	 * @var string
	 */
	private $object;
	
	/**
	 * The object
	 *
	 * @ORM\Column(name="bonus", type="string", length=255)
	 *
	 * @var string
	 */
	private $bonus;
	
	/**
	 * The job
	 *
	 * @ORM\Column(name="job", type="integer", nullable=true)
	 *
	 * @var int|null
	 */
	private $job;
	
	/**
	 * Get the identifier
	 * 
	 * @return int
	 */
	public function getId() {
		return ($this->id);
	}
	
	/**
	 * Get the date
	 * 
	 * @return \DateTime
	 */
	public function getDate() {
		return ($this->date);
	}
	
	/**
	 * Is current year
	 * 
	 * @return boolean
	 */
	public function isCurrentYear() {
		return ($this->date->format("Y") == (new \DateTime())->format("Y"));
	}
	
	/**
	 * Set the date
	 * 
	 * @param \DateTime $date
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}
	
	/**
	 * Get the quantity
	 * 
	 * @return int
	 */
	public function getQuantity() {
		return ($this->quantity);
	}
	
	/**
	 * Set the quantity
	 * 
	 * @param int $quantity
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}
	
	/**
	 * Get the object
	 * 
	 * @return string
	 */
	public function getObject() {
		return ($this->object);
	}
	
	/**
	 * Set the object
	 * 
	 * @param string $object
	 */
	public function setObject($object) {
		$this->object = $object;
	}
	
	/**
	 * Get the bonus
	 * 
	 * @return string
	 */
	public function getBonus() {
		return ($this->bonus);
	}
	
	/**
	 * Set the bonus
	 * 
	 * @param string $bonus
	 */
	public function setBonus($bonus) {
		$this->bonus = $bonus;
	}
	
	/**
	 * Get the job
	 * 
	 * @return int|null
	 */
	public function getJob() {
		return ($this->job);
	}
	
	/**
	 * Test if the almanax has a job.
	 * 
	 * @return boolean
	 */
	public function hasJob() {
		return (!is_null($this->job));
	}
	
	/**
	 * Set the job
	 * 
	 * @param int|null $job
	 */
	public function setJob($job) {
		$this->job = $job;
	}
}