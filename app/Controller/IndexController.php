<?php

namespace App\Controller;

use QueueManager\QueueModel;
use QueueManager\QueueManager;
use QueueManager\Senders\RedisQueueSender;
use RedisQueue\RedisQueue;
use System\Controller\AbstractController;
use App\Model\Dictionary\DictionaryRepository;
use App\Validator\SearchWordValidator;
use System\Database\DBManager\Mapping\ObjectMapper;
use System\Render;
use Widget\WidgetFactory;
use App\Model\Test\ModelTest;

class IndexController extends AbstractController
{
	/**
	 * @return Render
	 * @throws \Exception\ObjectException
	 * @throws \Exception\WidgetException
	 */
	public function indexAction(): Render
	{
	    $dataVideoFile = [
	        'file'        => 'C:/Users/v.konovalov/Downloads/ffmpeg/video.mp4',
            'newFilename' => 'video-screen-' . time() . '.jpeg',
            'newPath'     => 'C:/Users/v.konovalov/Downloads/ffmpeg/',
        ];

	    $res = ObjectMapper::create()->toObject([
	        'userId'    => 14,
            'name'      => 'dd',
            'userName'  => 'dsdsdsdsd',
            'firstName' => 'aaaa',
            'lastName'  => 'ccccccc'
        ], ModelTest::class);

        ObjectMapper::create()->toArray($res);

		$dictRepos = new DictionaryRepository();

		WidgetFactory::run('test');

		$send = (new QueueModel())
			->setName('converter-video-1')
			->setFlags('')
			->setExchangeName('converter-video-1')
			->setRoutingKey('sendMail')
			->setDataAsArray($dataVideoFile)
			->setType(AMQP_EX_TYPE_DIRECT);

		QueueManager::create()
			->sender($send)
			->send();

		return $this->render('index.html', [
			'dictionaries' => $dictRepos->getAllDictionaries()
		]);
	}

	/**
	 * @param int $id
	 * @return Render
	 * @throws \Exception
	 */
	public function dictionaryAction(int $id): Render
	{
		$dictRepos = new DictionaryRepository();

		return $this->render('random-word.html', [
			'dictionary' => $dictRepos->getDictionaryById($id)
		]);
	}

	/**
	 * @return Render
	 */
	public function searchWordAction(): Render
	{
		$send = (new QueueModel())
			->setData(time())
			->setName('testQueue');

		/** @var RedisQueueSender $manager */
		$manager = QueueManager::create()
			->setSender(new RedisQueueSender())
			->sender($send)
            ->setDataForSend((string) time());

		for ($i = 0; $i < 5000; $i++) {
            $manager->send();
        }

		$dictRepos = new DictionaryRepository();
		$validator = new SearchWordValidator();

		if ($validator->isPost()) {
			if (!$validator->isValid()) {
				return $this->render('search-word.html');
			}

			$dictRepos->searchWord($_POST);
		}

		return $this->render('search-word.html');
	}
}
