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
use Models\User\User;
use Helper\FlashText;
use System\Controller\AbstractController;
use System\Render;

class UserController extends AbstractController
{
	public function checkAuthAction()
	{
		echo User::current()->isAuth();
	}

	/**
	 * @return \System\Render
	 * @throws \Exception
	 */
	public function authAction(): Render
	{
		$validator = (new AuthValidator())->setUseIfPost();

		if ($validator->isValid()) {

			$user = User::current();
			$user->loadByEmailOrLogin($validator);

			if ($user->isLoaded()) {
				$user->authentication();

				if ($user->isAuth()) {
					$this->redirectToRoute('profileUser');
				}
			} else {
				$validator->setExtraErrorArray($user->getErrors());
			}
		}

		return $this->render('auth/auth.html');
	}

	/**
	 * @return Render
	 * @throws \Exception\FileException
	 */
	public function registerAction(): Render
	{
		$validator = (new RegisterValidator())->setUseIfPost();

		if ($validator->isValid()) {
			$user = User::create()
				->setPassword($validator->getValueField('password'))
				->setLogin($validator->getValueField('login'))
				->setEmail($validator->getValueField('email'))
				->createUser();

			if ($user->isSaved()) {
				FlashText::add('success', 'Вы успешно зарегистрированы!');
			} else {
				$validator->setExtraErrorArray($user->getErrors());
			}
		}

		return $this->render('auth/register.html');
	}

	public function profileAction(): Render
	{
		if (!User::current()->isAuth()) {
			$this->redirectToRoute('authUser');
		}

		return $this->render('user/profile.html');
	}

	public function logoutAction()
	{
		User::current()->logout();
		$this->redirect(URL);
	}
}