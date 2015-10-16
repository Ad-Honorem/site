<?php

namespace ADH\BetBundle\Entity;

use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * The pari entity
 *
 * @ORM\Entity(repositoryClass="ADH\BetBundle\Repository\PariRepository")
 * @ORM\Table(name="Paris")
 */
class Pari {
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

	public function __construct() {
		$this->ladate = new \Datetime();
                $this->etat = 0;
	}
	
	/**
	 * @ORM\ManyToOne(targetEntity="ADH\BetBundle\Entity\Match", inversedBy="match_paris", cascade={"persist"})
	 * @ORM\JoinColumn(name="lematch", onDelete="SET NULL", nullable=true)
	 */
	private $match;
	
	/**
	 *
	 * @var string @ORM\Column(name="pseudo", type="string", length=255)
	 */
	private $pseudo;
	
	/**
	 *
	 * @var int @ORM\Column(name="montant", type="integer")
	 */
	private $montant;
        
        /**
	 *
	 * @var int @ORM\Column(name="etat", type="integer")
	 */
	private $etat;
	
	/**
	 *
	 * @var int @ORM\Column(name="resultat", type="integer", nullable = true)
	 */
	private $resultat;
	
	/**
	 *
	 * @var string $ladate
	 *
	 * @ORM\Column(name="ladate", type="datetime", nullable=false)
	 * @Assert\DateTime()
	 *
	 */
	private $ladate;
        
        /**
	 *
	 * @var string $validationdate
	 *
	 * @ORM\Column(name="validationdate", type="datetime", nullable=true)
	 * @Assert\DateTime()
	 *
	 */
	private $validationdate;

	/**
	 * Get match
	 *
	 * @return \ADH\BetBundle\Entity\Match
	 */
	public function getMatch() {
		return $this->match;
	}

	/**
	 * Set match
	 *
	 * @param \ADH\BetBundle\Entity\Match $match 
	 * @return Match
	 */
	public function setMatch(Match $match = null) {
		$this->match = $match;
		
		return $this;
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
	 * Set ladate
	 *
	 * @param \DateTime $ladate 
	 * @return Match
	 */
	public function setLadate($ladate) {
		$this->ladate = $ladate;
	}

	/**
	 * Get ladate
	 *
	 * @return \DateTime
	 */
	public function getLadate() {
		return $this->ladate;
	}
        
        /**
	 * Set ladate
	 *
	 * @param \DateTime validationdate 
	 * @return Match
	 */
	public function setValidationdate($validationdate) {
		$this->validationdate = $validationdate;
	}

	/**
	 * Get validationdate
	 *
	 * @return \DateTime
	 */
	public function getValidationdate() {
		return $this->validationdate;
	}

	public function getPseudo() {
		return ($this->pseudo);
	}

	/**
	 * Set the pseudo
	 *
	 * @param
	 * string pseudo
	 */
	public function setPseudo($pseudo) {
		$this->pseudo = $pseudo;
	}

	/**
	 * Set the montant
	 *
	 * @param
	 * int montant
	 */
	public function setMontant($montant) {
		$this->montant = $montant;
	}
        
        public function getMontant() {
		return $this->montant;
	}

	/**
	 * Set the etat
	 *
	 * @param
	 * int etat
	 */
	public function setEtat($etat) {
		$this->etat = $etat;
	}


	public function getEtat() {
		return $this->etat;
	}
        
        public function getEtatString() {
            return (($this->etat == 0)?("Non validé"):("Validé"));
        }
        
        public function getResultat() {
            return $this->resultat;
        }

	public function setResultat($resultat) {
		$this->resultat = $resultat;
	}
}
