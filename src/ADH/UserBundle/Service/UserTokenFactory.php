<?php

namespace ADH\UserBundle\Service;

use ADH\UserBundle\Entity\TokenType;
use ADH\UserBundle\Entity\User;
use ADH\UserBundle\Entity\UserToken;

use Doctrine\ORM\EntityManagerInterface;

class UserTokenFactory {
	/**
	 * Entity manager
	 * 
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	
	/**
	 * 
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager) {
		$this->entityManager = $entityManager;
	}
	
	/**
	 * Create a user token.
	 * 
	 * @param User $user
	 * @param unknown $type
	 * @param \DateTime $expirationDate
	 * @param array $context
	 * @return \ADH\UserBundle\Entity\UserToken|null
	 */
	public function create(User $user, $type, \DateTime $expirationDate = null, array $context = null) {
		$token = null;
		$type = $this->getTokenType($type);
		
		if (!is_null($type)) {
			$token = $this->getClearToken($user, $type);
				
			if (!is_null($expirationDate)) {
				$token->setExpirationDate($expirationDate);
			}
			if (!is_null($context)) {
				$token->setContext($context);
			}
		}
		return ($token);
	}
	
	/**
	 * Create a user token and persist it in database.
	 *
	 * @param User $user
	 * @param unknown $type
	 * @param \DateTime $expirationDate
	 * @param array $context
	 * @return Ambigous <\ADH\UserBundle\Entity\UserToken, NULL>
	 */
	public function createAndPersist(User $user, $type, \DateTime $expirationDate = null, array $context = null) {
		$token = $this->create($user, $type, $expirationDate, $context);
	
		if (!is_null($token)) {
			$this->entityManager->persist($token);
			$this->entityManager->flush();
		}
		return ($token);
	}
	
	/**
	 * Create a user token, persist it in database and send it.
	 *
	 * @param User $user
	 * @param TokenType $type
	 * @param string $expirationDate
	 * @param array $context
	 * @return \ADH\UserBundle\Entity\UserToken
	 */
	public function createPersistAndSend(User $user, $type, \DateTime $expirationDate = null, array $context = null) {
		$token = $this->create($user, $type, $expirationDate, $context);
	
		if (!is_null($token)) {
			$this->sendToken($token);
		}
		return ($token);
	}
	
	/**
	 * Get the token type
	 * 
	 * @param string $type
	 * @return TokenType|null $tokenType;
	 */
	private function getTokenType($type) {
		return ($this->entityManager->getRepository("ADHUserBundle:TokenType")->findOneByType($type));
	}
	
	/**
	 * Get a clear token
	 * 
	 * @param User $user
	 * @param TokenType $type
	 * @return \ADH\UserBundle\Entity\UserToken
	 */
	private function getClearToken(User $user, TokenType $type) {
		$token = $this->entityManager->getRepository("ADHUserBundle:UserToken")->findOneByUserAndType($user, $type) ?: new UserToken();
			
		$token->generateToken();
		$token->resetExpirationDate();
		$token->clearContext();
		
		$token->setUser($user);
		$token->setType($type);
		return ($token);
	}
	
	/**
	 * 
	 * @param UserToken $token
	 */
	private function sendToken(UserToken $token) {
		// TODO send email
	}
}