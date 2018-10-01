<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 1:22
 */

namespace App\Controller;

use App\Validator\AuthValidator;
use App\Validator\RegisterValidator;
use App\Model\ORM\User;
use System\Controller\AbstractController;
use System\Render;

class UserController extends AbstractController
{
	/**
	 * @return \System\Render
	 * @throws \Exception
	 */
	public function authAction(): Render
	{
		$validator = (new AuthValidator())->setUseIfPost();

		if ($validator->isValid()) {

			$user = new User();
			$user->loadUser($validator);

			if ($user->isLoaded()) {
				$user->authorization();
			}
		}

		return $this->render('auth/auth.html');
	}

	/**
	 * @return \System\Render
	 */
	public function registerAction(): Render
	{
		$validator = new RegisterValidator();
		$validator->setUseIfPost();

		if ($validator->isValid()) {
			$user = new User();
			$user->addUser();
		}

		return $this->render('auth/register.html');
	}

	public function logoutAction()
	{
		$this->redirect(URL);
	}
}