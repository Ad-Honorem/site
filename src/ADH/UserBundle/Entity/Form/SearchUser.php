<?php

namespace ADH\UserBundle\Entity\Form;

class SearchUser {
	/**
	 * The user
	 * 
	 * @var \ADH\UserBundle\Entity\User
	 */
	private $user;
	
	/**
	 * Set the user
	 * 
	 * @param \ADH\UserBundle\Entity\User $user
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 * Get the user
	 * 
	 * @return \ADH\UserBundle\Entity\User
	 */
	public function getUser() {
		return ($this->user);
	}
}