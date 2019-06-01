<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 22:04
 */

namespace ES\App\Validator;

use ES\Kernel\Helper\Util;
use ES\Kernel\System\Validators\AbstractValidator;
use ES\Kernel\System\Validators\Validators;

class AuthValidator extends AbstractValidator
{
	/**
	 * @var bool
	 */
	public $isUseFlashErrors = true;

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function validate(): void
	{
		$message = Util::getFormMessage(Validators::REGISTER);

		$this->validateCSRFToken();

		if (!$this->isPost()) {
			$this->stackErrors['query'] = $message['query'];
		}

		if (empty($_POST['login'])) {
			$this->stackErrors['login'] = $message['login'];
		}

		if (empty($_POST['password'])) {
			$this->stackErrors['password'] = $message['password'];
		}
	}
}