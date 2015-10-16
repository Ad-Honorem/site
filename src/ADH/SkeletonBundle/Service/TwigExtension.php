<?php

namespace ADH\SkeletonBundle\Service;

class TwigExtension extends \Twig_Extension {

	/**
	 * (non-PHPdoc)
	 *
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions() {
		return (array(
				new \Twig_SimpleFunction("async", array($this,"async"), array("is_safe" => array("html")))
		));
	}

	/**
	 * Async
	 *
	 * @param string $url 
	 * @param array $options 
	 * @return string
	 */
	public function async($url, array $options = array()) {
		$options = array_merge(array(
				"default" => "<p class=\"align-center\">Cliquez <a href=\"%s\">ici</a> si la page ne se charge pas.</p>",
				"load" => "<p class=\"align-center\"><a href=\"%s\"><span class=\"loader horizontal-loader\"></span></a></p>",
				"fail" => "<p class=\"align-center\">Le chargement a échoué, cliquez <a href=\"%s\">ici</a> pour accéder à la page.</p>",
				"tag" => "div",
				"class" => "",
				"wait" => false,
				"url" => $url
		), $options);
		
		return ("<" . $options["tag"] . " class=\"async-data " . $options["class"] . "\" data-url=\"" . $url . "\" data-load=\"" . htmlentities(sprintf($options["load"], $options["url"]), ENT_QUOTES) . "\" data-fail=\"" . htmlentities(sprintf($options["fail"], $options["url"]), ENT_QUOTES) . "\" " . (($options["wait"]) ? ("data-wait=\"true\"") : ("")) . ">" . sprintf($options["default"], $options["url"]) . "</" . $options["tag"] . ">");
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Twig_ExtensionInterface::getName()
	 */
	public function getName() {
		return ("adh_extension");
	}
}