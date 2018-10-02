<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:21
 */

namespace App\Model\ORM;

use Configs\Config;
use Helper\Redis;
use Helper\Util;
use System\Database\DB;
use System\Database\ORM\ORM;
use System\Validators\AbstractValidator;

class User extends ORM
{
	protected $isLoaded = false;

	protected $table = 'user';

	protected $primaryKey = 'userId';

	private $userId;

	private $login;

	private $password;

	private $email;

	private $isSaved =  false;

	public function getUserId(): string
	{
		return $this->userId;
	}

	public function setLogin(string $login): self
	{
		$this->login = $login;

		return $this;
	}

	public function getLogin(): string
	{
		return $this->login;
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
		return $this->login;
	}

	/**
	 * @param string $password
	 * @return User
	 * @throws \Exception\FileException
	 */
	public function setPassword(string $password): self
	{
		$this->password = \password_hash($password . Config::get('salt', 'passwordUser'), PASSWORD_DEFAULT);

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

	/**
	 * @return bool
	 */
	public function isSaved(): bool
	{
		return $this->isSaved;
	}

	public function isGranted(int $role)
	{

	}

	public function addUser()
	{
		$role     = 1;

		$this->isSaved = DB::MySQLAdapter()->insert('
			INSERT INTO `user`
			(
				password, 
				email, 
				login, 
				role, 
				created
			)
			VALUES (
				"' . $this->password . '",
			    "' . $this->email . '", 
			    "' . $this->login . '", 
			    ' . $role . ', 
			    "' . Util::toDbTime() . '")
		');
	}
}