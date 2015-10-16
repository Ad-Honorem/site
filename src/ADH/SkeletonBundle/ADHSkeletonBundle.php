<?php

namespace ADH\SkeletonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use ADH\SkeletonBundle\CompilerPass\NavbarTagCompilerPass;

class ADHSkeletonBundle extends Bundle {
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
	 */
	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new NavbarTagCompilerPass());
	}
}
