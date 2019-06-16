<?php

namespace ES\App\Validator;

use ES\Kernel\Validators\AbstractValidator;

class SearchWordValidator extends AbstractValidator
{
	/**
	 * @var array
	 */
	private $errors = [
		'Не заполнен текст.',
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
		$this->validateCSRFToken();

		if (empty($_POST['text'])) {
			$this->stackErrors['text'] = $this->errors[0];
		}
	}
}