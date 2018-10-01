<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:21
 */

namespace App\Model\ORM;

use Helper\Redis;
use Helper\Util;
use Http\Session\Session;
use System\Database\DB;
use System\Database\ORM\ORM;
use System\Validators\AbstractValidator;

class User extends ORM
{
	protected $isLoaded = false;

	protected $table = 'user';

	protected $primaryKey = 'userId';

	private $userId;

	private $username;

	private $password;

	private $email;

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

	public function setHashPassword(string $password): self
	{
		$this->password = \md5($password);

		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function authorization()
	{
		//$token = Util::generateCookieToken();
		//\setcookie('JWT', $token);

		Redis::set('hh5', '113434434111');

		echo Redis::get('hh5');
	}

	/**
	 * @param AbstractValidator $form
	 * @return array
	 */
	public function loadUser(AbstractValidator $form): array
	{
		$user = DB::MySQLAdapter()->fetchRow('
			SELECT * 
			FROM user
			WHERE 
				(`login` = "' . $form->getLogin() . '" 
				OR `email` = "' . $form->getEmail() . '")
				AND `password` = "' . $form->getPassword() . '"
			LIMIT 1
		');

		if (!empty($user)) {
			$this->isLoaded = true;
		}

		return $user;
	}

	/**
	 * @return bool
	 */
	public function isLoaded(): bool
	{
		return $this->isLoaded;
	}

	public function current()
	{

	}

	public function isAuth()
	{

	}

	public function isGranted(int $role)
	{

	}

	public function addUser()
	{
		DB::MySQLAdapter()->insert('
			INSERT INTO `user`
			(password, email, login, role, created)
			VALUES ("sds", "sdsd", "sdsd", 1, "2222-11-11 11:1:11")
		');
	}
}