<?php

namespace ADH\UserBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ChangeEmail {
	/**
	 * The mail
	 * 
	 * @Assert\Email()
	 * 
	 * @var string
	 */
	private $email;
	
	/**
	 * Get the mail
	 * 
	 * @return string
	 */
	public function getEmail() {
		return ($this->email);
	}
	
	/**
	 * Set the mail
	 * 
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
}