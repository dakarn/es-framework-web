<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 18:30
 */

namespace App\Model\Dictionary;

class DictionaryRepository
{
	/** @var  DictionaryStorage */
	private $storage;

	/**
	 * @var array
	 */
	private $dictList = [];

	/**
	 * @return DictionaryStorage
	 */
	public function getDictionaryStorage(): DictionaryStorage
	{
		if (!$this->storage instanceof DictionaryStorage) {
			$this->storage = new DictionaryStorage();
		}

		return $this->storage;
	}

	/**
	 * @return array
	 */
	public function getAllDictionaries(): array
	{
		$results = $this->getDictionaryStorage()
			->getDictionaries();

		foreach ($results as $result) {
			$this->dictList[$result['id']] = new Dictionary($result);
		}

		return $this->dictList;
	}

	/**
	 * @param int $id
	 * @return Dictionary
	 * @throws \Exception
	 */
	public function getDictionaryById(int $id): Dictionary
	{
		$result = $this->getDictionaryStorage()
			->getDictionaryById($id);

		if (empty($result)) {
			throw new \Exception('Dictionary with ' . $id . ' not found!');
		}

		return new Dictionary($result);

	}

	/**
	 * @param array $data
	 */
	public function searchWord(array $data)
	{
		$dictionary = new Dictionary($data);

		$this->getDictionaryStorage()
			->searchDictionaryByText($dictionary);
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	public function addWord(array $data): bool
	{
		$dictionary = new Dictionary($data);

		$result = $this->getDictionaryStorage()
			->getDictionaryByText($dictionary);

		if (!empty($result)) {
			return false;
		}

		$this->getDictionaryStorage()
			->addWord($dictionary);

		return true;
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function deleteWord(int $id): bool
	{
		$this->getDictionaryStorage()
			->deleteWord($id);

		return true;
	}
}