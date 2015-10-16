<?php

namespace ADH\SkeletonBundle\Service\NavbarLeaves;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractNavbarLeaf implements NavbarLeafInterface {
	/**
	 * Request stack
	 * 
	 * @var RequestStack
	 */
	protected $request_stack;
	
	/**
	 * Router
	 *
	 * @var RouterInterface
	 */
	protected $router;
	
	/**
	 * Translator
	 *
	 * @var TranslatorInterface
	 */
	protected $translator;
	
	/**
	 * Name
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * Route
	 *
	 * @var string
	 */
	protected $route;
	
	/**
	 * Icon
	 * 
	 * @var string
	 */
	protected $icon;
	
	/**
	 * Route params
	 * 
	 * @var array
	 */
	protected $routeParams;
	
	/**
	 * Route type
	 * 
	 * @var boolean
	 */
	protected $routeType;

	/**
	 * 
	 * @param RequestStack $request_stack
	 * @param RouterInterface $router
	 * @param TranslatorInterface $translator
	 * @param string $name
	 * @param string $route
	 * @param string $icon
	 * @param array $routeParams
	 * @param boolean $routeType
	 */
	public function __construct(RequestStack $request_stack, RouterInterface $router, TranslatorInterface $translator, $name, $route, $icon = "", array $routeParams = array(), $routeType = RouterInterface::ABSOLUTE_PATH) {
		$this->request_stack = $request_stack;
		$this->router = $router;
		$this->translator = $translator;
		$this->name = $name;
		$this->route = $route;
		$this->icon = $icon;
		$this->routeParams = $routeParams;
		$this->routeType = $routeType;
	}

	/**
	 * Test if the leef is displayable
	 *
	 * @return boolean $display
	 */
	public function isDisplayable() {
		return (true);
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \ADH\SkeletonBundle\Models\NavbarLeefInterface::isOpened()
	 */
	public function isOpened() {
		return (false);
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \ADH\SkeletonBundle\Models\NavbarLeefInterface::isCurrent()
	 */
	public function isCurrent() {
		return ($this->request_stack->getMasterRequest()->attributes->get("_route", null) === $this->route);
	}

	/**
	 * Get the leef name
	 *
	 * @return string $name
	 */
	public function getName() {
		return ($this->translator->trans($this->name));
	}

	/**
	 * Get the leef route
	 *
	 * @return string $route
	 */
	public function getRoute() {
		return ($this->router->generate($this->route, $this->routeParams, $this->routeType));
	}

	/**
	 * Get the leef icon
	 *
	 * @return null|string $icon
	 */
	public function getIcon() {
		return ($this->icon);
	}
}
