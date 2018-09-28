<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.2018
 * Time: 18:31
 */

class User
{
	private $login;

	private $userId;

	private $password;

	private $username;

	public function __construct(array $property)
	{
		$this->userId   = $property['userId'];
		$this->login    = $property['login'];
		$this->password = $property['password'];
		$this->username = $property['username'];
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getLogin(): string
	{
		return $this->login;
	}

	public function getUserId(): string
	{
		return $this->userId;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setUsername(string $username): self
	{
		$this->username = $username;
		return $this;
	}

	public function setLogin(string $login): self
	{
		$this->login = $login;
		return $this;
	}

	public function setUserId(string $userId): self
	{
		$this->userId = $userId;
		return $this;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}
}