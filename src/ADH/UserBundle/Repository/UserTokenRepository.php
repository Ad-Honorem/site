<?php

namespace ADH\UserBundle\Repository;

use ADH\UserBundle\Entity\TokenType;
use ADH\UserBundle\Entity\User;
use ADH\UserBundle\Entity\UserToken;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class UserTokenRepository extends EntityRepository {
	/**
	 * Data encode
	 *
	 * @param string $data
	 * @return string
	 */
	public function dataEncode($data) {
		return (rtrim(strtr(base64_encode($data), "+/", "-_"), "="));
	}
	
	/**
	 * Decode data
	 *
	 * @param string $data
	 * @return string
	 */
	public function dataDecode($data) {
		return (base64_decode(str_pad(strtr($data, "-_", "+/"), strlen($data) % 4, "=", STR_PAD_RIGHT)));
	}
	
	/**
	 * Get token
	 * 
	 * @param User $user
	 * @param TokenType $type
	 * @return \Doctrine\ORM\mixed
	 */
	public function findOneByUserAndType(User $user, TokenType $type) {
		return ($this->createQueryBuilder("ut")
				->where("ut.user = :user")
				->andWhere("ut.type = :type")
			->getQuery()
				->setParameters(array(
						"user" => $user,
						"type" => $type
				))
			->getOneOrNullResult());
	}
	
	/**
	 * Find token
	 * 
	 * @param string $user
	 * @param string $type
	 * @param string $token
	 * @return \ADH\UserBundle\Entity\UserToken|null
	 */
	public function findOne($user, $type, $token) {
		return ($this->createQueryBuilder("ut")
			->innerJoin("ADHUserBundle:User", "u", Expr\Join::WITH, "u.id = ut.user")
			->innerJoin("ADHUserBundle:TokenType", "tt", Expr\Join::WITH, "tt.id = ut.type")
				->where("u.username = :user")
				->andWhere("tt.type = :type")
				->andWhere("ut.token = :token")
				->andWhere("ut.expiration_date > :date")
			->getQuery()
				->setParameters(array(
						"user" => $user,
						"type" => $type,
						"token" => $token,
						"date" => new \DateTime()
				))
			->getOneOrNullResult());
	}
}