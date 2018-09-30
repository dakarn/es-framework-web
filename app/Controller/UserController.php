<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 1:22
 */

namespace App\Controller;

use System\Controller\AbstractController;

class UserController extends AbstractController
{
	public function authAction()
	{
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