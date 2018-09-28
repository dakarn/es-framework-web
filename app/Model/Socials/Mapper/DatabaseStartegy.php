<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.2018
 * Time: 19:04
 */

class DatabaseStartegy
{
	private $data = [
		0 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		1 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		2 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		3 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		4 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		5 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		6 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		7 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		8 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		9 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
		10 => ['username' => 'Vlad', 'password' => '222', 'login' => 'Log', 'userId' => 4444],
	];

	public function fetchData(): array
	{
		return $this->data;
	}
}