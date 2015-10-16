<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The token type entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="TokenTypes")
 */
class TokenType {
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
	 * The type
	 *
	 * @ORM\Column(name="type", type="string", length=64, unique=true)
	 *
	 * @var string
	 */
	private $type;
	
	/**
	 * The type
	 *
	 * @ORM\Column(name="action", type="string", length=128)
	 *
	 * @var string
	 */
	private $action;
	
	/**
	 * The roles
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\UserToken", mappedBy="type")
	 */
	private $tokens;
	
	/**
	 * Get the identifier
	 * 
	 * @return number
	 */
	public function getId() {
		return ($this->id);
	}
	
	/**
	 * Get the type
	 * 
	 * @return string
	 */
	public function getType() {
		return ($this->type);
	}
	
	/**
	 * Get the action
	 * 
	 * @return string
	 */
	public function getAction() {
		return ($this->action);
	}
	
	/**
	 * Get the tokens
	 * 
	 * @return mixed
	 */
	public function getTokens() {
		return ($this->tokens);
	}
}