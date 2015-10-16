<?php

namespace ADH\NewsBundle\Entity;

use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The pari entity
 *
 * @ORM\Entity(repositoryClass="ADH\NewsBundle\Repository\CategoryNewsRepository")
 * @ORM\Table(name="CategoryNews")
 */
class CategoryNews {
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
	 * @ORM\Column(name="nom", type="string", length=255, nullable=false)
	 * 
	 * @var string
	 */
	private $nom;
	
	/**
	 * @ORM\Column(name="icone", type="string", length=127, nullable=true)
	 *
	 * @var string
	 */
	private $icone;
	
	/**
	 * @ORM\Column(name="type", type="string", length=16, nullable=true)
	 *
	 * @var string
	 */
	private $type;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User",cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="auteur", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $auteur;
	
	/**
	 * @Assert\DateTime()
	 * @ORM\Column(name="creationdate", type="datetime", nullable=false)
	 *
	 * @var string $creation
	 */
	private $creationdate;
	
	/**
	 * 
	 */
	public function __construct() {
		$this->creationdate = new \Datetime();
		$this->auteur = null;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function __toString() {
		return ($this->nom);
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
	 * Set auteur
	 *
	 * @param \ADH\UserBundle\Entity\User $auteur
	 * @return User
	 */
	public function setAuteur(\ADH\UserBundle\Entity\User $auteur = null) {
		$this->auteur = $auteur;
		
		return $this;
	}

	/**
	 * Get auteur
	 *
	 * @return \ADH\UserBundle\Entity\User
	 */
	public function getAuteur() {
		return $this->auteur;
	}

	/**
	 * Set creationdate
	 *
	 * @param \DateTime $creationdate
	 * @return Match
	 */
	public function setCreationdate($creationdate) {
		$this->creationdate = $$creationdate;
	}

	/**
	 * Get creationdate
	 *
	 * @return \DateTime
	 */
	public function getCreationdate() {
		return $this->creationdate;
	}

	public function getNom() {
		return ($this->nom);
	}

	/**
	 * Set the nom
	 *
	 * @param string nom
	 */
	public function setNom($nom) {
		$this->nom = $nom;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function hasType() {
		return (!is_null($this->type));
	}
	
	/**
	 *
	 * @return string
	 */
	public function getType() {
		return ($this->type);
	}
	
	/**
	 * Set the type
	 *
	 * @param string icone
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function hasIcone() {
		return (!is_null($this->icone));
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getIcone() {
		return ($this->icone);
	}

	/**
	 * Set the icone
	 *
	 * @param string icone
	 */
	public function setIcone($icone) {
		$this->icone = $icone;
	}
}
