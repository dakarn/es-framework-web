<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 22:04
 */

namespace App\Validator;

use System\Validators\AbstractValidator;

class AuthValidator extends AbstractValidator
{
	/**
	 * @var array
	 */
	private $errors = [
		'Не заполнен логин или email.',
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
			$this->stackErrors['query'] = $this->errors[2];
		}

		if (empty($_POST['login'])) {
			$this->stackErrors['login'] = $this->errors[0];
		}

		if (empty($_POST['password'])) {
			$this->stackErrors['password'] = $this->errors[1];
		}
	}
}