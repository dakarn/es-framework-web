<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.2018
 * Time: 18:36
 */

class UserMapper
{
	private $mapper = [];
	private $data = [];

	private $userList = [];

	public function __construct(StorageRepository $storage)
	{
		$this->mapper = $storage;
	}

	public function build()
	{
		$this->data = $this->mapper->getData();

		foreach ($this->data as $userId => $user) {
			$this->userList[$userId] = $this->mapToRows($user);
		}
	}

	public function findById(int $id): User
	{
		if (isset($this->userList[$id])) {
			return $this->userList[$id];
		}

		throw new Exception('User not found!');
	}

	private function mapToRows(array $data): User
	{
		return new User($data);
	}

	public function save(User $obj)
	{
		print_r($obj);
	}
}