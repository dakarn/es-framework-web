<?php

namespace ES\App\Controller;

use ES\Kernel\QueueManager\QueueModel;
use ES\Kernel\QueueManager\QueueManager;
use ES\Kernel\QueueManager\Senders\RedisQueueSender;
use ES\Kernel\Controller\AbstractController;
use ES\App\Model\Dictionary\DictionaryRepository;
use ES\App\Validator\SearchWordValidator;
use ES\Kernel\Logger\LogLevel;
use ES\Kernel\Helper\Render;
use ES\Kernel\Widget\WidgetFactory;
use ES\App\Model\Test\ModelTest;
use ES\Kernel\ObjectMapper\ObjectMapper;

class IndexController extends AbstractController
{
	/**
	 * @return Render
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function indexAction(): Render
	{
		for ($i =0; $i < 10000; $i++) {
			$this->log(LogLevel::INFO, 'Test Kafka Queue for log ' . $i);
		}


		return $this->render('test.html');
	}

	public function logViewAction(): Render
	{
		return $this->render('log-view.html');
	}

	/**
	 * @return Render
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\ObjectException
	 * @throws \ES\Kernel\Exception\WidgetException
	 */
	public function index1Action(): Render
	{
	    $dataVideoFile = [
	        'file'        => 'C:/Users/v.konovalov/Downloads/ffmpeg/video.mp4',
            'newFilename' => 'video-screen-' . \time() . '.jpeg',
            'newPath'     => 'C:/Users/v.konovalov/Downloads/ffmpeg/',
        ];

	    $res = ObjectMapper::create()->arrayToObject([
	        'userId'    => 14,
            'name'      => 'dd',
            'userName'  => 'dsdsdsdsd',
            'firstName' => 'aaaa',
            'lastName'  => 'ccccccc'
        ], ModelTest::class);

        ObjectMapper::create()->objectToArray($res);

		$dictRepos = new DictionaryRepository();

		WidgetFactory::run('test');

		$send = (new QueueModel())
			->setTopicName('converter-video-1')
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
		return $this->render('test.html');
	}

	/**
	 * @return Render
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function searchWordAction(): Render
	{
		$send = (new QueueModel())
			->setData(\time())
			->setTopicName('testQueue');

		/** @var RedisQueueSender $manager */
		$manager = QueueManager::create()
			->setSender(new RedisQueueSender())
			->sender($send)
            ->setDataString((string) \time());

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
