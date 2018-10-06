<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2018
 * Time: 21:24
 */

namespace App\Model\User;

use System\Validators\AbstractValidator;

interface UserInterface
{
	/**
	 * @return User
	 */
	public static function current(): User;

	/**
	 * @return User
	 */
	public static function create(): User;

	/**
	 * User constructor.
	 */
	public function __construct();

	/**
	 * @return UserStrategy
	 */
	public function getStrategyUser(): UserStrategy;

	/**
	 * @return array
	 */
	public function getErrors(): array;

	/**
	 * @param string $created
	 * @return User
	 */
	public function setCreated(string $created): User;

	/**
	 * @return string
	 */
	public function getCreated(): string;

	/**
	 * @return string
	 */
	public function getUserId(): string;

	/**
	 * @param string $login
	 * @return User
	 */
	public function setLogin(string $login): User;

	/**
	 * @return string
	 */
	public function getLogin(): string;

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): User;

	/**
	 * @return string
	 */
	public function getEmail(): string;

	/**
	 * @param string $role
	 * @return User
	 */
	public function setRole(string $role): User;

	/**
	 * @return string
	 */
	public function getRole(): string;

	/**
	 * @return string
	 */
	public function getPassword(): string;

	/**
	 * @param string $password
	 * @return User
	 * @throws \Exception\FileException
	 */
	public function setPassword(string $password): User;

	/**
	 * @throws \Exception
	 */
	public function authorization();

	/**
	 * @param AbstractValidator $form
	 * @throws \Exception\FileException
	 */
	public function loadByEmailOrLogin(AbstractValidator $form);

	/**
	 * @return bool
	 */
	public function isLoaded(): bool;

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function isAuth(): bool;

	/**
	 * @return bool
	 */
	public function isSaved(): bool;

	/**
	 * @param int $role
	 * @return bool
	 */
	public function isGranted(int $role): bool;

	/**
	 * @return User
	 * @throws \Exception\FileException
	 */
	public function createUser(): User;

	/**
	 * @param array $props
	 */
	public function setProperties(array $props);
}