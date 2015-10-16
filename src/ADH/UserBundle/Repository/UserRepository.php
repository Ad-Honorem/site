<?php

namespace ADH\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

use ADH\UserBundle\Entity\User;

class UserRepository extends EntityRepository {

	/**
	 * Get the user by username or email
	 * 
	 * @param string $identifier the identifier
	 */
	public function findOneByUsernameOrEmail($identifier) {
		$builder = $this->createQueryBuilder("u");
		
		if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
			$builder->where("u.email = :identifier");
		} else {
			$builder->where("u.username = :identifier");
		}
		$query = $builder->getQuery()->setParameter("identifier", $identifier);
		try {
			return ($query->getOneOrNullResult());
		} catch (NonUniqueResultException $e) {
			return (null);
		}
	}
	
	/**
	 * Is the user already exist
	 * 
	 * @param string $username
	 * @param string $email
	 * @return number
	 */
	public function isUserAlreadyExist($username, $email) {
		$return = User::NOT_ALREADY_USED;
		
		$query = $this->createQueryBuilder("u")
			->where("u.username = :username")
			->orWhere("u.email = :email")
		->getQuery();
		
		$query
			->setParameter("username", $username)
			->setParameter("email", $email);
		
		foreach ($query->execute() as $result) {
			if ($result->getUsername() === $username) {
				$return |= User::USERNAME_ALREADY_USED;
			}
			if ($result->getEmail() === $email) {
				$return |= User::EMAIL_ALREADY_USED;
			}
		}
		return ($return);
	}
}