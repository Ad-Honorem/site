<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\HttpKernel\KernelInterface::registerBundles()
	 */
	public function registerBundles() {
		$bundles = array(
				new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
				new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
				new Symfony\Bundle\AsseticBundle\AsseticBundle(),
				new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
				new Symfony\Bundle\MonologBundle\MonologBundle(),
				new Symfony\Bundle\SecurityBundle\SecurityBundle(),
				new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
				new Symfony\Bundle\TwigBundle\TwigBundle(),
				
				new FM\BbcodeBundle\FMBbcodeBundle(),
				
				/* our stuff */
				new ADH\AlmanaxBundle\ADHAlmanaxBundle(),
				new ADH\BetBundle\ADHBetBundle(),
				new ADH\BugTrackerBundle\ADHBugTrackerBundle(),
				new ADH\CharacterBundle\ADHCharacterBundle(),
				new ADH\NewsBundle\ADHNewsBundle(),
				new ADH\SkeletonBundle\ADHSkeletonBundle(),
				new ADH\UserBundle\ADHUserBundle(),
				new ADH\WYSIWYGBundle\ADHWYSIWYGBundle(),
		);
		
		if (in_array($this->getEnvironment(), array(
				"dev"
		))) {
			$bundles[] = new ADH\TestBundle\ADHTestBundle();
			
			$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
			
			$bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
			$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
		}
		return ($bundles);
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\HttpKernel\KernelInterface::registerContainerConfiguration()
	 */
	public function registerContainerConfiguration(LoaderInterface $loader) {
		$loader->load(__DIR__ . "/config/config_" . $this->getEnvironment() . ".yml");
	}
}
