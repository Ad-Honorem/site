<?php

namespace ADH\SkeletonBundle\Service\NavbarLeaves;

interface NavbarLeafInterface {
	/**
	 * Test if the leef is displayable
	 * 
	 * @return boolean $display
	 */
	public function isDisplayable();
	
	/**
	 * Test if the leef is opened
	 * 
	 * @return boolean $opened
	 */
	public function isOpened();
	
	/**
	 * Test if the leef is the current
	 * 
	 * @return boolean $current
	 */
	public function isCurrent();
	
	/**
	 * Get the leef name
	 * 
	 * @return string $name
	 */
	public function getName();
	
	/**
	 * Get the leef route
	 * 
	 * @return string $route
	 */
	public function getRoute();
	
	/**
	 * Get the leef icon
	 * 
	 * @return string $icon
	 */
	public function getIcon();
}