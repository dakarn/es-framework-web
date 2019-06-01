<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 1:22
 */

namespace ES\App\Controller;

use ES\Kernel\App\Validator\AuthValidator;
use ES\Kernel\App\Validator\RegisterValidator;
use ES\Kernel\Models\User\User;
use ES\Kernel\Helper\FlashText;
use ES\Kernel\System\Controller\AbstractController;
use ES\Kernel\System\Render;

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

			$user = User::loadByEmailOrLogin($validator);

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

	/**
	 * @return Render
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 * @throws \Exception\RoutingException
	 */
	public function profileAction(): Render
	{
		if (!User::current()->isAuth()) {
			$this->redirectToRoute('authUser');
		}

		return $this->render('user/profile.html');
	}

	/**
	 * @throws \Exception\FileException
	 */
	public function logoutAction()
	{
		User::current()->logout();
		$this->redirect(URL);
	}
}