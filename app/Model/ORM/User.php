<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:21
 */

namespace Model\ORM;

use System\Database\ORM\ORM;

class User extends ORM
{
	protected $table = 'user';

	protected $primaryKey = 'userId';

	private $userId;

	private $username;

	private $password;

	private $email;

	public function __construct(array $properties = [])
	{
		$this->username = $properties['username'] ?? '';
		$this->email    = $properties['email'] ?? '';
		$this->password = $properties['password'] ?? '';
	}

	public function getUserId(): string
	{
		return $this->userId;
	}

	public function setUsername(string $username): self
	{
		$this->username = $username;

		return $this;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->username;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function addUser()
	{

	}
}