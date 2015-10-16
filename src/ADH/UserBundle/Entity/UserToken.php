<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ADH\UserBundle\Entity\User;

/**
 * The user token entity
 *
 * @ORM\Entity(repositoryClass="ADH\UserBundle\Repository\UserTokenRepository")
 * @ORM\Table(name="UserTokens")
 */
class UserToken {
	/**
	 * The user
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\User", inversedBy="tokens", fetch="EAGER")
	 * @ORM\JoinColumn(name="userId", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var \ADH\UserBundle\Entity\User
	 */
	private $user;
	
	/**
	 * The type
	 *
	 * @ORM\Id()
	 * @ORM\ManyToOne(targetEntity="ADH\UserBundle\Entity\TokenType", inversedBy="tokens", fetch="EAGER")
	 * @ORM\JoinColumn(name="typeId", referencedColumnName="id", onDelete="CASCADE")
	 *
	 * @var \ADH\UserBundle\Entity\TokenType
	 */
	private $type;
	
	/**
	 * The token
	 *
	 * @ORM\Column(name="token", type="string", length=64)
	 *
	 * @var string
	 */
	private $token;
	
	/**
	 * The context
	 *
	 * @ORM\Column(name="context", type="string", length=128, nullable=true)
	 *
	 * @var string
	 */
	private $context;
	
	/**
	 * The context
	 *
	 * @ORM\Column(name="expiration_date", type="datetime")
	 *
	 * @var \DateTime
	 */
	private $expirationDate;
	
	/**
	 * 
	 */
	public function __construct() {
		$this->generateToken();
		$this->resetExpirationDate();
		$this->clearContext();
	}

	/**
	 * Get the user
	 * 
	 * @return \ADH\UserBundle\Entity\User
	 */
	public function getUser() {
		return ($this->user);
	}
	
	/**
	 * Set the user
	 * 
	 * @param \ADH\UserBundle\Entity\User $user
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}
	
	/**
	 * Get the type
	 * 
	 * @return \ADH\UserBundle\Entity\TokenType
	 */
	public function getType() {
		return ($this->type);
	}
	
	/**
	 * Set the type
	 * 
	 * @param \ADH\UserBundle\Entity\TokenType $type
	 */
	public function setType(TokenType $type) {
		$this->type = $type;
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
	 * Generate the token
	 * 
	 * @param number $round
	 * @param number $length
	 * @param number $offset
	 */
	public function generateToken($round = 3, $length = 64, $offset = 0) {
		$this->token = "";
		
		for (; $round > 0; --$round) {
			$this->token .= sha1(uniqid(mt_rand(), true));
		}
		$this->token = substr(base_convert($this->token, 16, 36), $offset, $length);
	}
	
	/**
	 * Has a context
	 *
	 * @return boolean
	 */
	public function hasContext() {
		return (!is_null($this->context));
	}
	
	/**
	 * Get the context
	 * 
	 * @return array|null
	 */
	public function getContext() {
		return (json_decode($this->context, true));
	}

	/**
	 * Clear the context
	 */
	public function clearContext() {
		$this->context = null;
	}
	
	/**
	 * Set the context
	 * 
	 * @param array $context
	 */
	public function setContext(array $context) {
		$this->context = json_encode($context);
	}
	
	/**
	 * Get the expiration date
	 * 
	 * @return \DateTime
	 */
	public function getExpirationDate() {
		return ($this->expirationDate);
	}
	
	/**
	 * Reset the expiration date
	 */
	public function resetExpirationDate() {
		$this->setExpirationDate(new \DateTime("+15 minutes"));
	}
	
	/**
	 * Set the expiration date
	 * 
	 * @param \DateTime $expirationDate
	 */
	public function setExpirationDate(\DateTime $expirationDate) {
		$this->expirationDate = $expirationDate;
	}
}