<?php

namespace ADH\UserBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class GroupHierarchy extends RoleHierarchy {
	/**
	 * The object manager
	 * 
	 * @var ObjectManager $objectManager
	 */
	private $objectManager;

	/**
	 * 
	 * @param array $hierarchy
	 * @param ObjectManager $objectManager
	 */
	public function __construct(array $staticHierarchy, ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
		parent::__construct($this->buildGroupTree($staticHierarchy));
	}

	/**
	 * Generate tree roles
	 * 
	 * @param array $hierarchy
	 * @return array
	 */
	private function buildGroupTree(array $staticHierarchy) {
		static $hierarchy = array();
		
		if (empty($hierarchy)) {
			foreach ($this->objectManager->getRepository("ADHUserBundle:GroupHierarchy")->findAll() as $groupHierarchy) {
				/* @var ADH\UserBundle\Entity\GroupHierarchy $groupHierarchy */
				$superior = $groupHierarchy->getSuperior()->getRole();
				$subordonate = $groupHierarchy->getSubordinate()->getRole();
				
				if (!array_key_exists($superior, $hierarchy)) {
					$hierarchy[$superior] = array();
				}
				$hierarchy[$superior][] = $subordonate;
			}
			$hierarchy = array_merge($hierarchy, $staticHierarchy);
		}
		return ($hierarchy);
	}
}