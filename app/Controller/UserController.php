<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 1:22
 */

namespace App\Controller;

use App\Validator\AuthValidator;
use Model\ORM\User;
use System\Controller\AbstractController;

class UserController extends AbstractController
{
	public function authAction()
	{
		$validator = new AuthValidator();
		$validator->setUseIfPost();

		if ($validator->isValid()) {
			$user = new User();

			$user
				->setEmail('dfdf')
				->setUsername('dfdf')
				->setPassword('dfdf')
				->addUser();
		}

		return $this->render('auth/auth.html');
	}

	public function registerAction()
	{
		return $this->render('auth/register.html');
	}

	public function logoutAction()
	{
		$this->redirect(URL);
	}
}