<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 18:35
 */

namespace App\Model\Dictionary;

use System\Database\DB;

class DictionaryStorage
{
	public function getDictionaries(): array
	{
		$data = [];
		$query = DB::create()->query('SELECT *
		FROM english_teacher 
		ORDER BY id LIMIT 20');

		while ($row = $query->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}

	public function addWord(Dictionary $dictionary): bool
	{

	}

	public function searchDictionaryByText(Dictionary $dictionary): bool
	{
		return true;
	}

	public function deleteWord(int $id): bool
	{

	}

	public function getDictionaryById(int $id): array
	{
		$query = DB::create()->query('SELECT *
		FROM english_teacher
		WHERE id = ' . $id);

		return $query->fetch_assoc();
	}

	public function getDictionaryByText(Dictionary $dictionary): array
	{
		$query = DB::create()->query('SELECT *
		FROM english_teacher
		WHERE text = "' . $dictionary->getText() . '"');

		return $query->fetch_assoc();
	}
}