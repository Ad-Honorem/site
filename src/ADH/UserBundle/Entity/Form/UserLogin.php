<?php

namespace ADH\UserBundle\Entity\Form;

class UserLogin {
	/**
	 * The username
	 * 
	 * @var string
	 */
	private $username;
	
	/**
	 * The password
	 * 
	 * @var string
	 */
	private $password;
	
	/**
	 * The remember me
	 * 
	 * @var boolean
	 */
	private $remember_me;
	
	/**
	 * Get the username
	 * 
	 * @return string
	 */
	public function getUsername() {
		return ($this->username);
	}
	
	/**
	 * Set the username
	 * 
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}
	
	/**
	 * Get the password
	 * 
	 * @return string
	 */
	public function getPassword() {
		return ($this->password);
	}
	
	/**
	 * Set the password
	 * 
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * Get the remember me
	 * 
	 * @return boolean
	 */
	public function isRememberMe() {
		return ($this->remember_me);
	}
	
	/**
	 * Set the remember me
	 * 
	 * @param boolean $remember_me
	 */
	public function setRememberMe($remember_me) {
		$this->remember_me = $remember_me;
	}
}
