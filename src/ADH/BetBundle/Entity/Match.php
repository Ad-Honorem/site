<?php

namespace ADH\BetBundle\Entity;

use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * The match entity
 *
 * @ORM\Entity(repositoryClass="ADH\BetBundle\Repository\MatchRepository")
 * @ORM\Table(name="Matchs")
 */
class Match {
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
	 * @ORM\ManyToOne(targetEntity="ADH\BetBundle\Entity\Equipe", inversedBy="equipeA_matchs", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="equipeA", onDelete="SET NULL", nullable=true)
	 */
	private $equipeA;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ADH\BetBundle\Entity\Equipe", inversedBy="equipeB_matchs", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="equipeB", onDelete="SET NULL", nullable=true)
	 */
	private $equipeB;
	
	/**
	 *
	 * @var string @ORM\Column(name="type", type="string", length=255)
	 */
	private $type;
	
	/**
	 *
	 * @var datetime $ladate
	 *
	 * @ORM\Column(name="ladate", type="datetime", nullable=false)
	 * @Assert\DateTime()
	 *
	 */
	private $ladate;
	
	/**
	 *
	 * @var string @ORM\Column(name="essaiA", type="integer")
	 */
	private $essaiA;
	
	/**
	 *
	 * @var string @ORM\Column(name="essaiB", type="integer")
	 */
	private $essaiB;
	
	/**
	 *
	 * @var string @ORM\Column(name="transA", type="integer")
	 */
	private $transA;
	
	/**
	 *
	 * @var string @ORM\Column(name="transB", type="integer")
	 */
	private $transB;
	
	/**
	 *
	 * @var string @ORM\Column(name="penA", type="integer")
	 */
	private $penA;
	
	/**
	 *
	 * @var string @ORM\Column(name="penB", type="integer")
	 */
	private $penB;
        
        	/**
	 *
	 * @var string @ORM\Column(name="dropA", type="integer")
	 */
	private $dropA;
	
	/**
	 *
	 * @var string @ORM\Column(name="dropB", type="integer")
	 */
	private $dropB;
	
	/**
	 * @ORM\OneToMany(targetEntity="ADH\BetBundle\Entity\Pari", mappedBy="match",cascade={"persist"})
	 */
	private $match_paris;

	public function __construct() {
		$this->essaiA = 0;
		$this->essaiB = 0;
		$this->penA = 0;
		$this->penB = 0;
		$this->transA = 0;
		$this->transB = 0;
                $this->dropA = 0;
                $this->dropB = 0;
		$this->match_paris = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function getMatchParis() {
		return $this->match_paris;
	}

	/**
	 * Add matchpari
	 *
	 * @param \ADH\BetBundle\Entity\Pari matchPari
	 * @return User
	 */
	public function addMatchParis(Pari $match_paris) {
		$this->match_paris[] = $match_paris;
		
		return $this;
	}

	/**
	 * Remove match_pari
	 *
	 * @param \ADH\BetBundle\Entity\Match equipeAMatch
	 */
	public function removeMatchParis(Pari $match_pari) {
		$this->match_paris->removeElement($match_pari);
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
	 * Set equipeA
	 *
	 * @param \ADH\BetBundle\Entity\Equipe $equipeA 
	 * @return Match
	 */
	public function setEquipeA(Equipe $equipeA = null) {
		$this->equipeA = $equipeA;
		
		return $this;
	}

	/**
	 * Get equipeB
	 *
	 * @return \ADH\BetBundle\Entity\EquipeB
	 */
	public function getEquipeB() {
		return $this->equipeB;
	}

	/**
	 * Set equipeB
	 *
	 * @param \ADH\BetBundle\Entity\Equipe $equipeB 
	 * @return Match
	 */
	public function setEquipeB(Equipe $equipeB = null) {
		$this->equipeB = $equipeB;
		
		return $this;
	}

	/**
	 * Get equipeA
	 *
	 * @return \ADH\BetBundle\Entity\EquipeA
	 */
	public function getEquipeA() {
		return $this->equipeA;
	}

	public function getType() {
		return ($this->type);
	}

	/**
	 * Set the Type
	 *
	 * @param string Type
	 */
	public function setType($type) {
		$this->type = $type;
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
	 * Get subscription_date
	 *
	 * @return \DateTime
	 */
	public function getLadate() {
		return $this->ladate;
	}

	public function getEssaiA() {
		return ($this->essaiA);
	}

	public function getPenA() {
		return ($this->penA);
	}

	/**
	 * Set the transA
	 *
	 * @param int transA
	 */
	public function setPenA($penA) {
		$this->penA = $penA;
	}

	public function getPenB() {
		return ($this->penB);
	}

	/**
	 * Set the penB
	 *
	 * @param int penB
	 */
	public function setPenB($penB) {
		$this->penB = $penB;
	}

	/**
	 * Set the essaiA
	 *
	 * @param int essaiA
	 */
	public function setEssaiA($essaiA) {
		$this->essaiA = $essaiA;
	}

	public function getEssaiB() {
		return ($this->essaiB);
	}

	/**
	 * Set the essaiB
	 *
	 * @param int essaiB
	 */
	public function setEssaiB($essaiB) {
		$this->essaiB = $essaiB;
	}

	public function getTransA() {
		return ($this->transA);
	}

	/**
	 * Set the transA
	 *
	 * @param int transA
	 */
	public function setTransA($transA) {
		$this->transA = $transA;
	}

	public function getTransB() {
		return ($this->transB);
	}

	/**
	 * Set the transB
	 *
	 * @param int transB
	 */
	public function setTransB($transB) {
		$this->transB = $transB;
	}
        
        public function getDropB() {
		return ($this->dropB);
	}

	/**
	 * Set the dropB
	 *
	 * @param int dropB
	 */
	public function setDropB($dropB) {
		$this->dropB = $dropB;
	}
        
                
        public function getDropA() {
		return ($this->dropA);
	}

	/**
	 * Set the dropA
	 *
	 * @param int dropA
	 */
	public function setDropA($dropA) {
		$this->dropA = $dropA;
	}

	public function getScoreA() {
		return ($this->essaiA * 5 + $this->transA * 2 + $this->penA * 3 + $this->dropA * 3);
	}

	public function getScoreB() {
		return ($this->essaiB * 5 + $this->transB * 2 + $this->penB * 3 + $this->dropB * 3);
	}

	public function getScore() {
		return ($this->getScoreA() . " - " . $this->getScoreB());
	}
}
