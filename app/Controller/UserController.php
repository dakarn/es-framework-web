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
use Helper\FlashText;
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
	 * @return Render
	 * @throws \Exception\FileException
	 */
	public function registerAction(): Render
	{
		$validator = new RegisterValidator();
		$validator->setUseIfPost();

		if ($validator->isValid()) {
			$user = new User();
			$user
				->setPassword($validator->getValueField('password'))
				->setLogin($validator->getValueField('login'))
				->setEmail($validator->getValueField('email'))
				->addUser();

			if ($user->isSaved()) {
				FlashText::add('success', 'Вы успешно зарегистрированы!');
			} else {
				FlashText::add('danger', 'Ошибка при создании пользователя!');
			}
		}

		return $this->render('auth/register.html');
	}

	public function logoutAction()
	{
		$this->redirect(URL);
	}
}