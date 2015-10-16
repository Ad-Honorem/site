<?php

namespace ADH\UserBundle\Entity\Form;

class ForgetRetrievePassword {
	/**
	 * @var string password
	 */
	private $password;
	
	/**
	 * Set the password
	 * 
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * Get the password
	 * 
	 * @return string
	 */
	public function getPassword() {
		return ($this->password);
	}
}