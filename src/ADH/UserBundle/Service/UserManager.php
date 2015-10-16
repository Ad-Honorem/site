<?php

namespace ADH\UserBundle\Service;

use ADH\UserBundle\Service\TokenManager;
use ADH\UserBundle\Entity\GroupUserPermission;
use ADH\Service\Mailer;
use ADH\UserBundle\Entity\User;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use ADH\UserBundle\Entity\UserToken;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

class UserManager implements UserProviderInterface {
	/**
	 * The mailer
	 *
	 * @var Mailer
	 */
	private $mailer;
	
	/**
	 * The encoder factory
	 *
	 * @var EncoderFactoryInterface $encoderFactory
	 */
	private $encoderFactory;
	
	/**
	 * The token storage
	 *
	 * @var TokenStorage $tokentStorage
	 */
	private $tokenStorage;
	
	/**
	 * The object manager
	 *
	 * @var ObjectManager
	 */
	private $entityManager;
	
	/**
	 * The user token factory
	 * 
	 * @var UserTokenFactory
	 */
	private $userTokenFactory;
	
	/**
	 * The user repository
	 *
	 * @var ADH\UserBundle\Repository\UserRepository
	 */
	private $userRepository;

	/**
	 * 
	 * @param EncoderFactoryInterface $encoderFactory
	 * @param TokenStorage $tokenStorage
	 * @param ObjectManager $entityManager
	 * @param UserTokenFactory $userTokenFactory
	 */
	public function __construct(EncoderFactoryInterface $encoderFactory, TokenStorage $tokenStorage, ObjectManager $entityManager, UserTokenFactory $userTokenFactory) {
		$this->encoderFactory = $encoderFactory;
		$this->tokenStorage = $tokenStorage;
		$this->entityManager = $entityManager;
		$this->userTokenFactory = $userTokenFactory;
		$this->userRepository = $this->entityManager->getRepository("ADH\\UserBundle\\Entity\\User");
	}

	/**
	 * Update the password of the user
	 *
	 * @param User $user 
	 * @return User
	 */
	public function updatePassword(User $user) {
		$plaintext_password = $user->getPlaintextPassword();
		
		if (!is_null($plaintext_password)) {
			$encoder = $this->encoderFactory->getEncoder($user);
			$user->setPassword($encoder->encodePassword($plaintext_password, $user->getSalt()));
			$user->eraseCredentials();
		}
		return ($user);
	}

	/**
	 * Register the user
	 *
	 * @param User $user 
	 */
	public function registerUser(User $user) {
		$expirationDate = new \DateTime("+7 days");

		/* update field */
		$user = $this->updatePassword($user);
		$user->setExpirationDate($expirationDate);

		/* insert the user (generate id) */
		$this->entityManager->persist($user);
		$this->entityManager->flush();
		$this->entityManager->refresh($user);
		
		/* create the token */
		$this->userTokenFactory->createPersistAndSend($user, "register_confirm", $expirationDate);
		return ($this->loginUser($user));
	}

	/**
	 * Log the user
	 *
	 * @param User $user 
	 * @return UsernamePasswordToken
	 */
	public function loginUser(User $user) {
		$token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
		$this->tokenStorage->setToken($token);
		
		return ($token);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::loadUserByUsername()
	 */
	public function loadUserByUsername($identifier) {
		$user = $this->userRepository->findOneByUsernameOrEmail($identifier);
		if ($user === null) {
			throw new UsernameNotFoundException("Username '" . $identifier . "' does not exist.");
		}
		return ($user);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::refreshUser()
	 */
	public function refreshUser(UserInterface $user) {
		$userClass = get_class($user);
		if (!$this->supportsClass($userClass)) {
			throw new UnsupportedUserException("Unsupported user '" . $userClass . "'");
		}
		
		/* @var ADH\UserBundle\Entity\User $user */
		if ($this->entityManager->contains($user)) {
			$this->entityManager->refresh($user);
		} else {
			$user = $this->userRepository->findOneById($user->getId());
		}
		if ($user === null) {
			throw new UsernameNotFoundException("User does not exist.");
		}
		return ($user);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::supportsClass()
	 */
	public function supportsClass($class) {
		return ($class == "ADH\\UserBundle\\Entity\\User" || is_subclass_of($class, "ADH\\UserBundle\\Entity\\User"));
	}
}
