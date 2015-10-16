<?php

namespace ADH\BugTrackerBundle\Entity;

use ADH\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * The bugtrackerticket entity
 *
 * @ORM\Entity(repositoryClass="ADH\BugTrackerBundle\Repository\BugTrackerTicketsRepository")
 * @ORM\Table(name="BugTrackerTickets")
 */
class BugTrackerTicket {
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
	 * The token
	 * 
	 * @ORM\Column(name="token", type="string", length=32, nullable=false)
	 * 
	 * @var string
	 */
	private $token;
	
	/**
	 * The reporter
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="reporter", referencedColumnName="id", onDelete="SET NULL")
	 * 
	 * @var User
	 */
	private $reporter;
	
	/**
	 * The category
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\BugTrackerBundle\Entity\BugTrackerCategory", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="category", referencedColumnName="id", onDelete="SET NULL")
	 * 
	 * @var BugTrackerCategory
	 */
	private $category;
	
	/**
	 * The title
	 * 
	 * @ORM\Column(name="title", type="string", length=128, nullable=false)
	 * 
	 * @var string
	 */
	private $title;
	
	/**
	 * The marks
	 * 
	 * @ORM\Column(name="marks", type="integer", nullable=false)
	 * 
	 * @var int
	 */
	private $marks;
	
	/**
	 * The description
	 * 
	 * @ORM\Column(name="description", type="text", nullable=false)
	 * 
	 * @var string
	 */
	private $description;
	
	/**
	 * The url
	 * 
	 * @ORM\Column(name="url", type="string", length=255, nullable=true)
	 * 
	 * @var string
	 */
	private $url;
	
	/**
	 * The privacy
	 * 
	 * @ORM\Column(name="public", type="boolean", nullable=false)
	 * 
	 * @var bool
	 */
	private $public;
	
	/**
	 * The state
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\BugTrackerBundle\Entity\BugTrackerState", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="state", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 * 
	 * @var BugTrackerState
	 */
	private $state;
	
	/**
	 * The assignee
	 * 
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", cascade={"persist"}, fetch="EAGER")
	 * @ORM\JoinColumn(name="assignee", referencedColumnName="id", onDelete="SET NULL")
	 * 
	 * @var User
	 */
	private $assignee;
	
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
	 * 
	 */
	public function __construct() {
		$this->generateToken();
		$this->creationDate = new \DateTime();
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
	 * Get the token
	 * 
	 * @return string
	 */
	public function getToken() {
		return ($this->token);
	}
	
	/**
	 * Generator the token
	 * 
	 */
	public function generateToken($round = 3, $length = 32, $offset = 0) {
		$this->token = "";
		
		for (; $round > 0; --$round) {
			$this->token .= sha1(uniqid(mt_rand(), true));
		}
		$this->token = substr(base_convert($this->token, 16, 36), $offset, $length);
	}
	
	/**
	 * Has reporter
	 * 
	 * @return boolean
	 */
	public function hasReporter() {
		return (!is_null($this->reporter));
	}

	/**
	 * Get reporter
	 * 
	 * @return User
	 */
	public function getReporter() {
		return ($this->reporter);
	}

	/**
	 * Set reporter
	 * 
	 * @param User $reporter
	 */
	public function setReporter(User $reporter) {
		$this->reporter = $reporter;
	}

	/**
	 * Has category
	 * 
	 * @return boolean
	 */
	public function hasCategory() {
		return (!is_null($this->category));
	}

	/**
	 * Get category
	 * 
	 * @return BugTrackerCategory
	 */
	public function getCategory() {
		return ($this->category);
	}

	/**
	 * Set category
	 * 
	 * @param BugTrackerCategory $category
	 */
	public function setCategory(BugTrackerCategory $category) {
		$this->category = $category;
	}

	/**
	 * Get title
	 * 
	 * @return string
	 */
	public function getTitle() {
		return ($this->title);
	}

	/**
	 * Set title
	 * 
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get marks
	 * 
	 * @return int
	 */
	public function getMarks() {
		return ($this->marks);
	}

	/**
	 * Set marks
	 * 
	 * @param int $marks
	 */
	public function setMarks($marks) {
		$this->marks = $marks;
	}

	/**
	 * Get description
	 * 
	 * @return string
	 */
	public function getDescription() {
		return ($this->description);
	}

	/**
	 * Set description
	 * 
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * Has a url
	 * 
	 * @return boolean
	 */
	public function hasUrl() {
		return (!is_null($this->url));
	}
	
	/**
	 * Get the url
	 * 
	 * @return string
	 */
	public function getUrl() {
		return ($this->url);
	}
	
	/**
	 * Set the url
	 * 
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}
	
	/**
	 * Get public
	 * 
	 * @return boolean
	 */
	public function getPublic() {
		return ($this->public);
	}

	/**
	 * Is public
	 * 
	 * @return boolean
	 */
	public function isPublic() {
		return ($this->public);
	}

	/**
	 * Is private
	 * 
	 * @return boolean
	 */
	public function isPrivate() {
		return (!$this->public);
	}
	
	/**
	 * Set public
	 * 
	 * @param boolean $public
	 */
	public function setPublic($public) {
		$this->public = $public;
	}

	/**
	 * Make public
	 */
	public function makePublic() {
		$this->public = true;
	}

	/**
	 * Make private
	 */
	public function makePrivate() {
		$this->public = false;
	}

	/**
	 * Get state
	 * 
	 * @return BugTrackerState
	 */
	public function getState() {
		return ($this->state);
	}

	/**
	 * Set state
	 * 
	 * @param BugTrackerState $state
	 */
	public function setState(BugTrackerState $state) {
		$this->state = $state;
	}

	/**
	 * Has assignee
	 * 
	 * @return boolean
	 */
	public function hasAssignee() {
		return (!is_null($this->assignee));
	}

	/**
	 * Get assignee
	 * 
	 * @return User
	 */
	public function getAssignee() {
		return ($this->assignee);
	}

	/**
	 * Set assignee
	 * 
	 * @param User $assignee
	 */
	public function setAssignee(User $assignee) {
		$this->assignee = $assignee;
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
