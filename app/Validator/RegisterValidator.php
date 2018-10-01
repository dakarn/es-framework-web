<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 22:03
 */

namespace App\Validator;

use System\Validators\AbstractValidator;

class RegisterValidator extends AbstractValidator
{
	/**
	 * @var array
	 */
	private $errors = [
		'Не заполнен логин.',
		'Не верно заполнен email.',
		'Не заполнен пароль.',
		'Не корректный запрос.',
	];

	/**
	 * @var bool
	 */
	public $isUseFlashErrors = true;

	/**
	 * @return void
	 */
	public function validate(): void
	{
		if (!$this->isPost()) {
			$this->stackErrors['query'] = $this->errors[3];
		}

		if (empty($_POST['login'])) {
			$this->stackErrors['login'] = $this->errors[0];
		}

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$this->stackErrors['email'] = $this->errors[1];
		}

		if (empty($_POST['password'])) {
			$this->stackErrors['password'] = $this->errors[2];
		}
	}
}