<?php

namespace ADH\UserBundle\EventListener;

use ADH\UserBundle\Entity\Annotation\GroupSecurityInterface;
use ADH\UserBundle\Entity\Group;
use ADH\UserBundle\Service\GroupSecurityChecker;

use Doctrine\Common\Annotations\Reader;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class GroupSecurityListener implements EventSubscriberInterface {
	/**
	 *
	 * @var GroupSecurityChecker
	 */
	protected $groupSecurityChecker;
	
	/**
	 *
	 * @var TokenStorageInterface
	 */
	protected $tokenStorage;
	
	/**
	 *
	 * @var RoleHierarchyInterface
	 */
	protected $roleHierarchy;
	
	/**
	 *
	 * @var ExpressionLanguage
	 */
	protected $language;
	
	/**
	 *
	 * @var Reader
	 */
	protected $reader;
	
	/**
	 *
	 * @var string
	 */
	protected $adminRole;

	/**
	 *
	 * @param PermissionChecker $permissionChecker 
	 * @param TokenStorageInterface $tokenStorage 
	 * @param RoleHierarchyInterface $roleHierarchy 
	 * @param ExpressionLanguage $language 
	 * @param Reader $reader 
	 * @param string $adminRole 
	 */
	public function __construct(GroupSecurityChecker $groupSecurityChecker, TokenStorageInterface $tokenStorage, RoleHierarchyInterface $roleHierarchy, ExpressionLanguage $language, Reader $reader, $adminRole) {
		$this->groupSecurityChecker = $groupSecurityChecker;
		$this->tokenStorage = $tokenStorage;
		$this->roleHierarchy = $roleHierarchy;
		$this->language = $language;
		$this->reader = $reader;
		$this->adminRole = $adminRole;
	}

	/**
	 *
	 * @param FilterControllerEvent $event 
	 */
	public function onKernelController(FilterControllerEvent $event) {
		if (is_array($controller = $event->getController())) {
			$request = $event->getRequest();
			
			$class = new \ReflectionClass(get_class($controller[0]));
			$method = $class->getMethod($controller[1]);
			
			foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
				if ($annotation instanceof GroupSecurityInterface) {
					$this->evaluate($annotation, $request);
				}
			}
		}
	}

	/**
	 * Evaluate the annotation
	 *
	 * @param GroupSecurityInterface $annotation
	 * @param Request $request 
	 */
	protected function evaluate(GroupSecurityInterface $annotation, Request $request) {
		$roles = array_map(function ($role) {
			return ($role->getRole());
		}, $this->roleHierarchy->getReachableRoles($this->tokenStorage->getToken()->getRoles()));
		
		if ($annotation->isStrictExpression() || !in_array($this->adminRole, $roles)) {
			if (!$this->language->evaluate($annotation->getExpression(), array(
					"group" => $this->getGroup($annotation, $request),
					"groupSecurityChecker" => $this->groupSecurityChecker
			))) {
				throw new AccessDeniedException("GroupSecurity's expression (\"" . $annotation->expression . "\") denied access.");
			}
		}
	}

	/**
	 * Get the group
	 * 
	 * @param GroupSecurityInterface $annotation
	 * @param Request $request
	 * @throws \LogicException
	 * @return \ADH\UserBundle\Entity\Group|NULL
	 */
	protected function getGroup(GroupSecurityInterface $annotation, Request $request) {
		if (!is_null($groupAttribute = $annotation->getGroup())) {
			return ($this->language->evaluate($groupAttribute, $request->attributes->all()));
		}
		foreach ($request->attributes->all() as $attribute) {
			if ($attribute instanceof Group) {
				return ($attribute);
			}
		}
		return (null);
	}

	/**
	 *
	 * @return multitype:string
	 */
	public static function getSubscribedEvents() {
		return array(
				KernelEvents::CONTROLLER => "onKernelController"
		);
	}
}