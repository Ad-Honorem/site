<?php

namespace ADH\UserBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePassword {
	/**
	 * The old password
	 * 
	 * @UserPassword()
	 * 
	 * @var string $old
	 */
	private $old;
	
	/**
	 * The new password
	 * 
	 * @Assert\Length(min=6, max=255)
	 * 
	 * @var string $new
	 */
	private $new;
	
	/**
	 * Get the old password
	 * 
	 * @return string
	 */
	public function getOld() {
		return ($this->old);
	}
	
	/**
	 * Set the old password
	 * 
	 * @param string $old
	 */
	public function setOld($old) {
		$this->old = $old;
	}
	
	/**
	 * Get the new password
	 * 
	 * @return string
	 */
	public function getNew() {
		return ($this->new);
	}
	
	/**
	 * Set the new password
	 * 
	 * @param string $new
	 */
	public function setNew($new) {
		$this->new = $new;
	}
}