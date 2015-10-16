<?php

namespace ADH\UserBundle\Entity\Annotation;

/**
 * @Annotation
 */
class GroupSecurity implements GroupSecurityInterface {
	/**
	 * 
	 * @var string
	 */
	public $expression;
	
	/**
	 *
	 * @var string
	 */
	public $group = null;
	
	/**
	 *
	 * @var bool
	 */
	public $strict_expression = false;
	
	/**
	 * Get the expression
	 * 
	 * @return string
	 */
	public function getExpression() {
		return ($this->expression);
	}
	
	/**
	 * Get the group
	 * 
	 * @return string
	 */
	public function getGroup() {
		return ($this->group);
	}
	
	/**
	 * Is strict expression
	 * 
	 * @return boolean
	 */
	public function isStrictExpression() {
		return ($this->strict_expression);
	}
}