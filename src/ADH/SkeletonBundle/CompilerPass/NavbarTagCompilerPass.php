<?php

namespace ADH\SkeletonBundle\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class NavbarTagCompilerPass implements CompilerPassInterface {
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
	 */
	public function process(ContainerBuilder $container) {
		if (!$container->has("adh_skeleton.navbar")) {
			return;
		}
		$definition = $container->findDefinition("adh_skeleton.navbar");
		
		foreach ($container->findTaggedServiceIds("adh_skeleton.navbar.leaf") as $serviceId => $tags) {
			foreach ($tags as $attributes) {
				$reference = new Reference($serviceId);
				$priority = ((array_key_exists("priority", $attributes)) ? ($attributes["priority"]) : (0));

				$definition->addMethodCall("addLeaf", array($reference, $priority));
			}
		}
	}
}
