<?php

namespace App\Controller;

use App\Model\Dictionary\Dictionary;
use App\Model\Dictionary\DictionaryRepository;
use Configs\Config;
use System\Controller\AbstractController;
use ElasticSearch\ElasticSearch;
use System\Render;

class ElasticController extends AbstractController
{
	/**
	 * @return Render
	 */
	public function addIndexAction(): Render
	{
		ElasticSearch::create()
			->setIndex('teacher')
			->setBody('PUT', [
				'mappings' => Config::get('elasticsearch', 'mappings')]
			)->execute();

		return $this->render('elastic/addindex.html');
	}

	/**
	 * @return Render
	 */
	public function removeIndexAction(): Render
	{
		ElasticSearch::create()
			->setIndex('teacher')
			->deleteIndex();

		return $this->render('elastic/addindex.html');
	}

	/**
	 * @return Render
	 */
	public function indexerAction(): Render
	{
		$dictRepos = new DictionaryRepository();
		$result    = $dictRepos->getAllDictionaries();
		$data      = '';

		/** @var Dictionary $item */
		foreach ($result as $item) {

			$data .= json_encode(['index' => ['_index' => 'teacher', '_type' => 'dictionary', '_id' => $item->getId()]]) . '\n';
			$data .= json_encode([
				'text'      => $item->getText(),
				'translate' => $item->getTranslate(),
				'type'      => $item->getType(),
				'level'     => $item->getLevel(),
				'audioFile' => $item->getAudioFile(),
			], JSON_UNESCAPED_UNICODE) . '\n';
		}

		ElasticSearch::create()
			->setPath('_bulk')
			->setBody('POST', $data)
			->execute()
			->getResult();

		return $this->render('elastic/addindex.html');
	}

	/**
	 * @return Render
	 */
	public function enterCommandAction(): Render
	{
		ElasticSearch::create()
			->setIndex('teacher')
			->setType('dictionary')
			->setId(1)
			->get();

		return $this->render('index.html');
	}
}