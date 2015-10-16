<?php

namespace ADH\BetBundle\Entity;

use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * The team entity
 *
 * @ORM\Entity(repositoryClass="ADH\BetBundle\Repository\EquipeRepository")
 * @ORM\Table(name="Equipes")
 */
class Equipe {
	
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
	 * The teamname
	 *
	 * @Assert\Length(min=5, max=64)
	 * @Assert\Regex("/^[A-Za-z0-9][a-z0-9]+([_-][A-Za-z0-9][a-z0-9]+)?/")
	 * @ORM\Column(name="nom", type="string", length=64)
	 *
	 * @var string
	 */
	private $nom;
	
	/**
	 * The flag
	 *
	 * @ORM\Column(name="drapeau", type="string", length=128, nullable=true)
	 *
	 * @var string
	 */
	private $drapeau;
	
	/**
	 * The pool
	 *
	 * @ORM\Column(name="poule", type="string", length=4)
	 *
	 * @var string
	 */
	private $poule;
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="ADH\BetBundle\Entity\Match", mappedBy="equipeA",cascade={"persist"})
	 */
	private $equipeA_matchs;
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="ADH\BetBundle\Entity\Match", mappedBy="equipeB",cascade={"persist"})
	 */
	private $equipeB_matchs;

	/**
	 * 
	 */
	public function __construct() {
		$this->equipeA_matchs = new \Doctrine\Common\Collections\ArrayCollection();
		
		$this->equipeB_matchs = new \Doctrine\Common\Collections\ArrayCollection();
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

	public function getNom() {
		return ($this->nom);
	}

	/**
	 * Set the nom
	 *
	 * @param string $nom
	 */
	public function setNom($nom) {
		$this->nom = $nom;
	}

	public function getDrapeau() {
		return ("images/flag/" . $this->drapeau);
	}

	/**
	 * Set the drapeau
	 *
	 * @param string $drapeau
	 */
	public function setDrapeau($drapeau) {
		$this->drapeau = $drapeau;
	}

	/**
	 * Set the poule
	 *
	 * @param string $poule
	 */
	public function setPoule($poule) {
		$this->poule = $poule;
	}

	public function getPoule() {
		return ($this->poule);
	}

	/**
	 * Add equipeA_match
	 *
	 * @param \ADH\BetBundle\Entity\Match $equipeAMatch 
	 * @return User
	 */
	public function addEquipeAMatch(Match $requipeA_matchs) {
		$this->equipeA_matchs[] = $equipeA_matchs;
		
		return $this;
	}

	/**
	 * Remove equipeA_match
	 *
	 * @param \ADH\BetBundle\Entity\Match $equipeAMatch
	 */
	public function removeEquipeAMatch(Match $requipeA_matchs) {
		$this->equipeA_matchs->removeElement($requipeA_matchs);
	}

	/**
	 * Add equipeB_match
	 *
	 * @param \ADH\BetBundle\Entity\Match $equipeBMatch
	 */
	public function addEquipeBMatch(Match $requipeB_matchs) {
		$this->equipeB_matchs[] = $equipeB_matchs;
	}

	/**
	 * Remove equipeB_match
	 *
	 * @param \ADH\BetBundle\Entity\Match $equipeBMatch
	 */
	public function removeEquipeBMatch(Match $requipeB_matchs) {
		$this->equipeB_matchs->removeElement($requipeB_matchs);
	}
}