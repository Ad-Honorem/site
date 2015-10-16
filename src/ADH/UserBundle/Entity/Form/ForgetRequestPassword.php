<?php

namespace ADH\UserBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ForgetRequestPassword {
	/**
	 * The email adresse
	 * 
	 * @Assert\Email()
	 * 
	 * @var string
	 */
	private $email;
	
	/**
	 * Set email
	 * 
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	 * Get email
	 * 
	 * @return string
	 */
	public function getEmail() {
		return ($this->email);
	}
}