<?php

namespace ADH\SkeletonBundle\Service;

use ADH\SkeletonBundle\Service\NavbarLeaves\NavbarLeafInterface;

use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class Navbar {
	/**
	 * 
	 * @var array
	 */
	private $leaves;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->leaves = array();
	}
	
	/**
	 * Add a leaf to the menu
	 * 
	 * @param NavbarLeefInterface $leef
	 */
	public function addLeaf(NavbarLeafInterface $leaf, $priority) {
		$this->leaves[] = array(
				"priority" => $priority,
				"leaf" => $leaf
		);
	}
	
	/**
	 * Get the navbar menu leaves
	 * 
	 * @return array
	 */
	public function getLeaves() {
		$leaves = array();
		
		usort($this->leaves, array($this, "sortLeaves"));
		foreach ($this->leaves as $leaf) {
			try {
				if ($leaf["leaf"]->isDisplayable()) {
					$leaves[] = array(
							"opened" => $leaf["leaf"]->isOpened(),
							"current" => $leaf["leaf"]->isCurrent(),
							"name" => $leaf["leaf"]->getName(),
							"route" => $leaf["leaf"]->getRoute(),
							"icon" => $leaf["leaf"]->getIcon()
					);
				}
			} catch (AuthenticationCredentialsNotFoundException $e) {
				// Error 404
			}
		}
		return ($leaves);
	}
	
	/**
	 * sort leaves
	 * 
	 * @param array $leaf1
	 * @param array $leaf2
	 * @return number
	 */
	private function sortLeaves($leaf1, $leaf2) {
		return ($leaf2["priority"] - $leaf1["priority"]);
	}
}