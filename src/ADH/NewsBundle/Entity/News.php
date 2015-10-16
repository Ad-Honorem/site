<?php

namespace ADH\NewsBundle\Entity;

use ADH\UserBundle\Entity\User;

use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * The pari entity
 * 
 * @ORM\Entity(repositoryClass="ADH\NewsBundle\Repository\NewsRepository")
 * @ORM\Table(name="News")
 */
class News {
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
	 * @ORM\Column(name="etat", type="integer")
	 *
	 * @var int
	 */
	private $etat;

	/**
	 * @ORM\Column(name="titre", type="string", length=255, nullable=false)
	 *
	 * @var string
	 */
	private $titre;

	/**
	 * @ORM\Column(name="texte", type="text", nullable=false)
	 * 
	 * @var string
	 */
	private $texte;

	/**
	 * @ORM\Column(name="source", type="string", length=255, nullable=true)
	 * 
	 * @var string
	 */
	private $source;

	/**
	 * @ORM\Column(name="motifRefus", type="string", length=255, nullable=true)
	 * 
	 * @var string
	 */
	private $motifRefus;

	/**
	 * @Assert\DateTime()
	 * @ORM\Column(name="creationdate", type="datetime", nullable=false)
	 *
	 * @var string $creation
	 */
	private $creationdate;
	
	/**
	 * @Assert\DateTime()
	 * @ORM\Column(name="publicationdate", type="datetime", nullable=true)
	 *
	 * @var string $publication
	 */
	private $publicationdate;
	
	/**
	 * @Assert\DateTime()
	 * @ORM\Column(name="editiondate", type="datetime", nullable=true)
	 *
	 * @var string $editiondate
	 */
	private $editiondate;

	/**
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User",cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="auteur", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $auteur;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User",cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="editeur", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $editeur;

	/**
	 * @ORM\ManyToOne(targetEntity="ADH\NewsBundle\Entity\CategoryNews",cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="categoryNews", referencedColumnName="id", onDelete="SET NULL", nullable=true)
	 */
	private $category;

	public function __construct() {
		$this->creationdate = new \Datetime();
		$this->auteur = null;
		$this->etat = 0;
		$this->editeur = null;
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
	 * 
	 * @return boolean
	 */
	public function hasAuteur() {
		return (!is_null($this->auteur));
	}

	/**
	 * Get auteur
	 *
	 * @return \ADH\UserBundle\Entity\User
	 */
	public function getAuteur() {
		return ($this->auteur);
	}
	
	/**
	 * Set auteur
	 *
	 * @param \ADH\UserBundle\Entity\User $auteur
	 * @return User
	 */
	public function setAuteur(User $auteur = null) {
		$this->auteur = $auteur;
	}
	
	/**
	 * Get Editeur
	 *
	 * @return \ADH\UserBundle\Entity\User
	 */
	public function getEditeur() {
		return ($this->editeur);
	}
	
	/**
	 * Set editeur
	 *
	 * @param \ADH\UserBundle\Entity\User $auteur
	 * @return User
	 */
	public function setEditeur(User $editeur = null) {
		$this->editeur = $editeur;
	}

	public function hasCategory() {
		return (!is_null($this->category));
	}

	/**
	 * Set categoryNews
	 *
	 * @param \ADH\newsBundle\Entity\User $categoryNews
	 * @return CategoryNews
	 */
	public function setCategory(CategoryNews $category = null) {
		$this->category = $category;
	}

	/**
	 * Get auteur
	 *
	 * @return \ADH\NewsBundle\Entity\CategoryNews
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Set creationdate
	 *
	 * @param \DateTime $creationdate
	 * @return Match
	 */
	public function setCreationdate($creationdate) {
		$this->creationdate = $creationdate;
	}

	/**
	 * Get creationdate
	 *
	 * @return \DateTime
	 */
	public function getCreationdate() {
		return $this->creationdate;
	}
	
	/**
	 * Set publicationdate
	 *
	 * @param \DateTime $publicationdate
	 * @return Match
	 */
	public function setPublicationdate($publicationdate) {
		$this->publicationdate = $publicationdate;
	}

	/**
	 * Get publicationdate
	 *
	 * @return \DateTime
	 */
	public function getPublicationdate() {
		return $this->publicationdate;
	}
	
	/**
	 * Set editiondate
	 *
	 * @param \DateTime $editiondate
	 * @return Match
	 */
	public function setEditiondate($editiondate) {
		$this->editiondate = $editiondate;
	}

	/**
	 * Get editiondate
	 *
	 * @return \DateTime
	 */
	public function getEditiondate() {
		return $this->editiondate;
	}

	public function getTitre() {
		return ($this->titre);
	}

	/**
	 * Set the titre
	 *
	 * @param string $titre
	 */
	public function setTitre($titre) {
		$this->titre = $titre;
	}

	public function getTexte() {
		return $this->texte;
	}

	/**
	 * Set the texte
	 *
	 * @param string $texte
	 */
	public function setTexte($texte) {
		$this->texte = $texte;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function hasSource() {
		return (!is_null($this->source));
	}

	public function getSource() {
		return $this->source;
	}

	/**
	 * Set the source
	 *
	 * @param string $source
	 */
	public function setSource($source) {
		$this->source = $source;
	}
	
	/**
	 * Has motif refus
	 * 
	 * @return boolean
	 */
	public function hasMotifRefus() {
		return (!is_null($this->motifRefus));
	}

	public function getMotifRefus() {
		return $this->motifRefus;
	}

	/**
	 * Set the motifRefus
	 *
	 * @param string $motifRefus
	 */
	public function setMotifRefus($motifRefus) {
		$this->motifRefus = $motifRefus;
	}

	/**
	 * Set the etat
	 *
	 * @param integer $etat
	 */
	public function setEtat($etat) {
		$this->etat = $etat;
	}

	public function getEtat() {
		return $this->etat;
	}
	
	/**
	 * 
	 * FIXME: Add table in database
	 * 
	 * @return string|NULL
	 */
	public function getEtatString() {
		switch($this->etat) {
			case 0:
				return ("Rédaction privée");
			case 1:
				return ("Rédaction publique");
			case 2:
				return ("Soumise pour publication");
			case 3:
				return ("Publiée");
			case 4:
				return ("Refusée");
		}
		return (null);
	}
}
