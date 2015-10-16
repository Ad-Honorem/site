<?php

namespace ADH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\ArrayType;

/**
 * The user entity
 *
 * @ORM\Entity(repositoryClass="ADH\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="Users")
 */
class User implements AdvancedUserInterface, EquatableInterface {
	const NOT_ALREADY_USED = 0;
	const USERNAME_ALREADY_USED = 1;
	const EMAIL_ALREADY_USED = 2;
	
	/**
	 * The identifier
	 *
	 * @ORM\Id()
	 * @ORM\Column(name="id", type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var int
	 */
	private $id;
	
	/**
	 * The username
	 *
	 * @ORM\Column(name="username", type="string", length=64, unique=true)
	 * @Assert\Regex("/^[A-Za-z0-9][a-z0-9]+([_-][A-Za-z0-9][a-z0-9]+)?/")
	 * @Assert\Length(min=5, max=64)
	 *
	 * @var string
	 */
	private $username;
	
	/**
	 * The pseudonyme
	 *
	 * @ORM\Column(name="pseudo", type="string", length=64, unique=true)
	 * @Assert\Regex("/^[A-Za-z0-9][a-z0-9]+([_-][A-Za-z0-9][a-z0-9]+)?/")
	 * @Assert\Length(min=5, max=64)
	 *
	 * @var string
	 */
	private $pseudo;
	
	/**
	 * The email
	 *
	 * @ORM\Column(name="email", type="string", length=255, unique=true)
	 * @Assert\Email()
	 *
	 * @var string
	 */
	private $email;
	
	/**
	 * The password
	 *
	 * @ORM\Column(name="password", type="string", length=255)
	 *
	 * @var string
	 */
	private $password;
	
	/**
	 * The plaintext password
	 *
	 * @Assert\Length(min=6, max=255)
	 *
	 * @var string $plaintext_password
	 */
	private $plaintext_password;
	
	/**
	 * The salt
	 *
	 * @ORM\Column(name="salt", type="string", length=255)
	 *
	 * @var string
	 */
	private $salt;
	
	/**
	 * The avatar
	 *
	 * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
	 *
	 * @var string
	 */
	private $avatar;
	
	/**
	 * The creation date
	 *
	 * @ORM\Column(name="creation_date", type="datetime")
	 *
	 * @var \DateTime
	 */
	private $creation_date;
	
	/**
	 * The modification date
	 *
	 * @ORM\Column(name="modification_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $modification_date;
	
	/**
	 * The connection date
	 *
	 * @ORM\Column(name="connection_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $connection_date;
	
	/**
	 * The validation date
	 *
	 * @ORM\Column(name="validation_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $validation_date;
	
	/**
	 * The expiration date
	 *
	 * @ORM\Column(name="expiration_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $expiration_date;
	
	/**
	 * The de-ban date
	 *
	 * @ORM\Column(name="ban_until_date", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $ban_until_date;
	
	/**
	 * The roles
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupUserPermission", mappedBy="user")
	 */
	private $groups;
	
	/**
	 * The officier roles
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\GroupUserPermission", mappedBy="officier", fetch="EXTRA_LAZY")
	 */
	private $officierRoles;
	
	/**
	 * The friend1
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\UserFriend", mappedBy="user1", fetch="EXTRA_LAZY")
	 */
	private $friends1;
	
	/**
	 * The friend2
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\UserFriend", mappedBy="user2", fetch="EXTRA_LAZY")
	 */
	private $friends2;
	
	/**
	 * The roles
	 *
	 * @ORM\OneToMany(targetEntity="ADH\UserBundle\Entity\UserToken", mappedBy="user", fetch="EXTRA_LAZY")
	 */
	private $tokens;

	/**
	 * Update the modification date
	 */
	private function updateModificationDate() {
		$this->modification_date = new \DateTime();
	}
	
	/**
	 */
	public function __construct() {
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
		$this->password_recovery = null;
		$this->ip = null;
		$this->connection_date = null;
		$this->creation_date = new \DateTime();
		$this->modification_date = null;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function __toString() {
		return ($this->pseudo);
	}

	/**
	 * Get the identifier
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->id);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
	 */
	public function getUsername() {
		return ($this->username);
	}

	/**
	 * Set the username
	 *
	 * @param string $username 
	 */
	public function setUsername($username) {
		if ($this->username !== $username) {
			$this->username = $username;
			$this->updateModificationDate();

			if (is_null($this->pseudo)) {
				$this->pseudo = $username;
			}
		}
	}

	/**
	 * Get the pseudo.
	 *
	 * @return string
	 */
	public function getPseudo() {
		return ($this->pseudo);
	}

	/**
	 * Set the pseudo
	 *
	 * @param string $pseudo 
	 */
	public function setPseudo($pseudo) {
		if ($this->pseudo !== $pseudo) {
			$this->pseudo = $pseudo;
			$this->updateModificationDate();
		}
	}

	/**
	 * Get the email
	 *
	 * @return string
	 */
	public function getEmail() {
		return ($this->email);
	}

	/**
	 * Set the email
	 *
	 * @param string $email 
	 */
	public function setEmail($email) {
		if ($this->email !== $email) {
			$this->email = $email;
			$this->updateModificationDate();
		}
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt() {
		return ($this->salt);
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getPassword()
	 */
	public function getPassword() {
		return ($this->password);
	}

	/**
	 * Set the password
	 *
	 * @param string $password 
	 */
	public function setPassword($password) {
		if ($this->password !== $password) {
			$this->password = $password;
			$this->updateModificationDate();
		}
	}

	/**
	 * Get the plaintext password
	 *
	 * @return string
	 */
	public function getPlaintextPassword() {
		return ($this->plaintext_password);
	}

	/**
	 * Set the plaintext password
	 *
	 * @param string $plaintext_password 
	 */
	public function setPlaintextPassword($plaintext_password) {
		$this->plaintext_password = $plaintext_password;
	}
	
	/**
	 * Has an avatar
	 * 
	 * @return boolean
	 */
	public function hasAvatar() {
		return (!is_null($this->avatar));
	}
	
	/**
	 * Get the avatar
	 * 
	 * @return string
	 */
	public function getAvatar() {
		return ($this->avatar);
	}
	
	/**
	 * Set the avatar
	 * 
	 * @param string $avatar
	 */
	public function setAvatar($avatar) {
		$this->avatar = $avatar;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles() {
		static $groups = array();
		
		if (empty($groups)) {
			$groups[] = Group::DEFAULT_GROUP;
			foreach ($this->groups as $groupUserPermission) {
				$groups[] = $groupUserPermission->getGroup()->getRole();
			}
		}
		return ($groups);
	}
	
	/**
	 * Get the group permissions
	 * 
	 * @return array
	 */
	public function getGroupPermissions() {
		return ($this->groups);
	}

	/**
	 * Get the connection date
	 * 
	 * @return \DateTime
	 */
	public function getConnectionDate() {
		return ($this->connection_date);
	}
	
	/**
	 * Update the connection date
	 */
	public function updateConnectionDate() {
		$this->connection_date = new \DateTime();
	}
	
	/**
	 * Has an expiration date
	 * 
	 * @return boolean
	 */
	public function hasExpirationDate() {
		return (!is_null($this->expiration_date));
	}
	
	/**
	 * Get the expiration date
	 * 
	 * @return DateTime
	 */
	public function getExpirationDate() {
		return ($this->expiration_date);
	}
	
	/**
	 * Clear the expiration date
	 */
	public function clearExpirationDate() {
		$this->expiration_date = null;
	}
	
	/**
	 * Set the expiration date
	 * 
	 * @param \DateTime $delay
	 */
	public function setExpirationDate(\DateTime $expiration_date) {
		$this->expiration_date = $expiration_date;
	}
	
	/**
	 * Is validated
	 *
	 * @return boolean
	 */
	public function isValidated() {
		return (!is_null($this->validation_date));
	}
	
	/**
	 * Get the validation date
	 * 
	 * @return DateTime
	 */
	public function getValidationDate() {
		return ($this->validation_date);
	}
	
	/**
	 * Validate a user
	 */
	public function validate() {
		if (!$this->isValidated()) {
			$this->validation_date = new \DateTime();
			$this->clearExpirationDate();
		}
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		$this->plaintext_password = null;
	}
	
	/**
	 * Is account non expired
	 * 
	 * @return boolean
	 */
	public function isAccountNonExpired() {
		return (is_null($this->expiration_date) || $this->expiration_date > new \DateTime());
	}
	
	/**
	 * Is account non lock
	 * 
	 * @return boolean
	 */
	public function isAccountNonLocked() {
		return (is_null($this->ban_until_date) || $this->ban_until_date < new \DateTime());
	}
	
	/**
	 * Is credentials non expired
	 * 
	 * @return boolean
	 */
	public function isCredentialsNonExpired() {
		return (true);
	}
	
	/**
	 * Is enabled
	 * 
	 * @return boolean
	 */
	public function isEnabled() {
		return (true);
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see \Symfony\Component\Security\Core\User\EquatableInterface::isEqualTo()
	 */
	public function isEqualTo(UserInterface $user) {
		return (get_class($user) == get_class($this) && $user->getPassword() == $this->getPassword() && $user->getUsername() == $this->getUsername());
	}
}
