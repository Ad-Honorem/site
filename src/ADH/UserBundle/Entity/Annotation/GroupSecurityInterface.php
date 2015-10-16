<?php

namespace ADH\UserBundle\Entity\Annotation;

use ADH\UserBundle\Entity\Group;

interface GroupSecurityInterface {
	/**
	 * Get the expression
	 * 
	 * @return string
	 */
	public function getExpression();
	
	/**
	 * Get the group
	 * 
	 * @return string
	 */
	public function getGroup();
	
	/**
	 * Is strict expression
	 * 
	 * @return boolean
	 */
	public function isStrictExpression();
}
