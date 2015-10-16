<?php

namespace ADH\BugTrackerBundle\Entity;

use ADH\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * The bugtrackerconversation entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="BugTrackerConversations")
 */
class BugTrackerConversation {
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
	 * The ticket
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\BugTrackerBundle\Entity\BugTrackerTicket", cascade={"persist"})
	 * @ORM\JoinColumn(name="ticket", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 * 
	 * @var BugTrackerTicket
	 */
	private $ticket;
	
	/**
	 * The autor
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="auteur", referencedColumnName="id", onDelete="SET NULL")
	 * 
	 * @var User
	 */
	private $autor;
	
	/**
	 * The message
	 * 
	 * @ORM\Column(name="message", type="text", nullable=false)
	 * 
	 * @var string
	 */
	private $message;
	
	/**
	 * The creation date
	 * 
	 * @ORM\Column(name="creation_date", type="datetime", nullable=false)
	 * 
	 * @var \DateTime
	 */
	private $creationDate;
	
	/**
	 * The modification date
	 * 
	 * @ORM\Column(name="modification_date", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $modificationDate;

	/**
	 * Get identifier
	 * 
	 * @return int
	 */
	public function getId() {
		return ($this->id);
	}

	/**
	 * Get ticket
	 * 
	 * @return string
	 */
	public function getTiket() {
		return ($this->tiket);
	}

	/**
	 * Set ticket
	 * 
	 * @param BugTrackerTicket $ticker
	 */
	public function setTiket(BugTrackerTicket $ticker) {
		$this->tiket = $ticket;
	}

	/**
	 * Has autor
	 * 
	 * @return boolean
	 */
	public function hasAutor() {
		return (!is_null($this->autor));
	}

	/**
	 * Get autor
	 * 
	 * @return User
	 */
	public function getAutor() {
		return ($this->autor);
	}

	/**
	 * Set autor
	 * 
	 * @param User $autor
	 */
	public function setAutor(User $autor) {
		$this->autor = $autor;
	}

	/**
	 * Get message
	 * 
	 * @return string
	 */
	public function getMessage() {
		return ($this->message);
	}

	/**
	 * Set message
	 * 
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Get creation date
	 * 
	 * @return \DateTime
	 */
	public function getCreationDate() {
		return ($this->creationDate);
	}
	
	/**
	 * Has modification date
	 * 
	 * @return boolean
	 */
	public function hasModificationDate() {
		return (!is_null($this->modificationDate));
	}

	/**
	 * Get modification date
	 * 
	 * @return \DateTime
	 */
	public function getModificationDate() {
		return ($this->modificationDate);
	}
}
