<?php

namespace ADH\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Mailer {
	/**
	 * The mailer
	 *
	 * @var \Swift_Mailer
	 */
	private $mailer;
	
	/**
	 * The request stack
	 *
	 * @var RequestStack
	 */
	private $request_stack;
	
	/**
	 * The http kernel
	 *
	 * @var HttpKernelInterface
	 */
	private $http_kernel;

	/**
	 *
	 * @param \Swift_Mailer $mailer 
	 */
	public function __construct(\Swift_Mailer $mailer, RequestStack $request_stack, HttpKernelInterface $http_kernel) {
		$this->mailer = $mailer;
		$this->request_stack = $request_stack;
		$this->http_kernel = $http_kernel;
	}

	/**
	 * Extract the title from the content
	 *
	 * @param string $content 
	 * @return string
	 */
	private function extractTitle($content) {
		if (preg_match("#<title>(.+)<\/title>#isU", $content, $matches) && isset($matches[1]))
			return ($matches[1]);
		return ("");
	}

	/**
	 * Message from scratch
	 *
	 * @return \Swift_Message
	 */
	public function createMessageFromScratch() {
		return ($this->mailer->createMessage());
	}

	/**
	 * Default message
	 *
	 * @return \Swift_Message
	 */
	public function createDefaultMessage() {
		$message = $this->mailer->createMessage();
		
		$message->setFrom("adh@dev-adh.esy.es");
		return ($message);
	}

	/**
	 * Controller message
	 *
	 * @param string $to 
	 * @param string $controller 
	 * @param array $controllerParameter 
	 * @return \Swift_Message
	 */
	public function createControllerMessage($to, $controller, array $controllerParameter = array()) {
		$message = $this->createDefaultMessage();
		$messageContent = $this->http_kernel->handle($this->request_stack->getCurrentRequest()->duplicate(array(), null, array_merge($controllerParameter, array(
				"_controller" => $controller
		))), HttpKernelInterface::SUB_REQUEST)->getContent();
		
		$message->setTo($to);
		$message->setSubject($this->extractTitle($messageContent));
		$message->setBody($messageContent, "text/html");
		return ($message);
	}

	/**
	 * Template message
	 *
	 * @param string $to 
	 * @param string $template 
	 * @param array $templateParameter 
	 * @return \Swift_Message
	 */
	public function createTemplateMessage($to, $template, array $templateParameter = array()) {
		$message = $this->createDefaultMessage();
		$messageContent = $this->renderView($template, $templateParameter);
		
		$message->setTo($to);
		$message->setSubject($this->extractTitle($messageContent));
		$message->setBody($messageContent, "text/html");
		return ($message);
	}

	/**
	 * Simple message
	 *
	 * @param string $to 
	 * @param string $subject 
	 * @param string $content 
	 * @param string $contentMime 
	 * @return \Swift_Message
	 */
	public function createMessage($to, $subject, $content, $contentMime = "text/html") {
		$message = $this->createDefaultMessage();
		$messageContent = $this->renderView($template, $templateParameter);
		
		$message->setTo($to);
		$message->setSubject($subject);
		$message->setBody($content, $contentMime);
		return ($message);
	}

	/**
	 * Create and send a controller message
	 *
	 * @param string $to 
	 * @param string $controller 
	 * @param array $controllerParameter 
	 * @return number
	 */
	public function sendControllerMessage($to, $controller, array $controllerParameter = array()) {
		return ($this->send($this->createControllerMessage($to, $controller, $controllerParameter)));
	}

	/**
	 * Create and send a template message
	 *
	 * @param string $to 
	 * @param string $template 
	 * @param array $templateParameter 
	 * @return number
	 */
	public function sendTemplateMessage($to, $template, array $templateParameter = array()) {
		return ($this->send($this->createTemplateMessage($to, $template, $templateParameter)));
	}

	/**
	 * Create and send a simple message
	 *
	 * @param string $to 
	 * @param string $subject 
	 * @param string $content 
	 * @param string $contentMime 
	 * @return number
	 */
	public function sendMessage($to, $subject, $content, $contentMime = "text/html") {
		return ($this->send($this->createMessage($to, $subject, $content, $contentMime)));
	}

	/**
	 * Send a message
	 *
	 * @param \Swift_Message $message 
	 * @return number
	 */
	public function send(\Swift_Message $message) {
		return ($this->mailer->send($message));
	}
}