<?php

namespace App\Validator;

use System\Validators\AbstractValidator;

class AddWordValidator extends AbstractValidator
{
	/**
	 * @var array
	 */
	private $errors = [
		'Не заполнен текст.',
		'Неверный запрос.',
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
			$this->stackErrors['query'] = $this->errors[1];
		}

		if (empty($_POST['text'])) {
			$this->stackErrors['text'] = $this->errors[0];
		}
	}
}