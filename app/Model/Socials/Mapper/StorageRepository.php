<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.2018
 * Time: 18:31
 */

class StorageRepository
{
	private $data = [];
	private $strategy;

	public function __construct(DatabaseStartegy $strategy)
	{
		$this->strategy = $strategy;
	}

	public function fetchData()
	{
		$this->data = $this->strategy->fetchData();
	}

	public function getData(): array
	{
		return $this->data;
	}
}