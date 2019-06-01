<?php /** @noinspection ALL */

namespace ES\App\Controller;

use ES\App\Model\Dictionary\Dictionary;
use ES\App\Model\Dictionary\DictionaryRepository;
use ES\Kernel\Configs\Config;
use ES\Kernel\System\Controller\AbstractController;
use ES\Kernel\ElasticSearch\ElasticSearch;
use ES\Kernel\System\Render;

class ElasticController extends AbstractController
{
	/**
	 * @return Render
	 * @throws \ES\Kernel\Exception\FileException
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
	 * @throws \Exception\FileException
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
	 * @throws \Exception\FileException
	 */
	public function indexerAction(): Render
	{
		$dictRepos = new DictionaryRepository();
		$result    = $dictRepos->getAllDictionaries();
		$data      = '';

		/** @var Dictionary $item */
		foreach ($result as $item) {

			$data .= \json_encode(['index' => ['_index' => 'teacher', '_type' => 'dictionary', '_id' => $item->getId()]]) . '\n';
			$data .= \json_encode([
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
	 * @throws \Exception\FileException
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