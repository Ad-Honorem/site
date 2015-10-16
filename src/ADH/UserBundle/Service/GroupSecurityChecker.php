<?php

namespace ADH\UserBundle\Service;

use ADH\UserBundle\Entity\Group;
use ADH\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ADH\UserBundle\Entity\GroupUserPermission;

class GroupSecurityChecker {
	
	/**
	 *
	 * @var TokenStorageInterface
	 */
	protected $tokenStorage;

	/**
	 *
	 * @param TokenStorageInterface $tokenStorage 
	 */
	public function __construct(TokenStorageInterface $tokenStorage) {
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * User can
	 *
	 * @param User $user 
	 * @param string $action 
	 * @param Group $group 
	 */
	public function userCan(Group $group, $action) {
		if (!is_null($permission = $this->getUserPermission($group))) {
			$methodName = "has" . implode("", array_map(function ($word) {
				return (ucfirst($word));
			}, preg_split("#[\s_-]+#", $action, -1, PREG_SPLIT_NO_EMPTY))) . "Right";
			
			if (!method_exists($permission, $methodName)) {
				throw new \LogicException("The user action '" . $action . "' does not exist.");
			}
			return ($permission->$methodName());
		}
		return (false);
	}

	/**
	 *
	 * @param string $status 
	 * @param Group $group 
	 * @return boolean
	 */
	public function groupIs(Group $group, $status) {
		$methodName = "is" . ucfirst($status);
		
		if (!method_exists($group, $methodName)) {
			throw new \LogicException("The group status '" . $status . "' does not exist.");
		}
		return ($group->$methodName());
	}
	
	/**
	 * Get user permission
	 *
	 * @param Group $group
	 * @return GroupUserPermission|NULL
	 */
	public function getUserPermission(Group $group) {
		static $permissions = array();
	
		if (array_key_exists($group->getRole(), $permissions)) {
			return ($permissions[$group->getRole()]);
		}
		if (($user = $this->tokenStorage->getToken()->getUser()) instanceof User) {
			foreach ($user->getGroupPermissions() as $permission) {
				if ($permission->getGroup()->isEqualTo($group)) {
					return ($permissions[$group->getRole()] = $permission);
				}
			}
		}
		return (null);
	}
}