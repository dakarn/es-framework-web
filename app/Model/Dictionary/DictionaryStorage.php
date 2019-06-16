<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 18:35
 */

namespace ES\App\Model\Dictionary;

use ES\Kernel\Database\DB;

class DictionaryStorage
{
	public function getDictionaries(): array
	{
		$data = DB::getMySQL()->getTeacher()->fetch('SELECT *
		FROM english_teacher 
		ORDER BY id LIMIT 20');

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
		$query = DB::getMySQL()->getTeacher()->fetch('SELECT *
		FROM english_teacher
		WHERE id = ' . $id);

		return $query;
	}

	public function getDictionaryByText(Dictionary $dictionary): array
	{
		$query = DB::getMySQL()->getTeacher()->fetch('SELECT *
		FROM english_teacher
		WHERE text = "' . $dictionary->getText() . '"');

		return $query;
	}
}