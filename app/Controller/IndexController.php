<?php

namespace App\Controller;

use Configs\Config;
use QueueManager\QueueModel;
use QueueManager\QueueManager;
use QueueManager\Senders\RedisQueueSender;
use System\Controller\AbstractController;
use App\Model\Dictionary\DictionaryRepository;
use App\Validator\SearchWordValidator;
use System\Database\DB;
use System\Database\ORM\Mapping\ObjectMapper;
use System\Render;
use Widget\WidgetFactory;
use App\Model\Test\ModelTest;

class IndexController extends AbstractController
{
	/**
	 * @return Render
	 * @throws \Exception\FileException
	 */
	public function indexAction(): Render
	{
		$rr = DB::MySQLAdapter()
			->prepare('SELECT * FROM user WHERE userId=?', DB::READ)
			->bindParams('i', [21]);
		$rr->execute();

		return $this->render('test.html');
	}

	public function logViewAction(): Render
	{
		return $this->render('log-view.html');
	}

	/**
	 * @return Render
	 * @throws \Exception\FileException
	 * @throws \Exception\ObjectException
	 * @throws \Exception\WidgetException
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
		return $this->render('test.html');
	}

	/**
	 * @return Render
	 * @throws \Exception\FileException
	 */
	public function searchWordAction(): Render
	{
		$send = (new QueueModel())
			->setData(\time())
			->setName('testQueue');

		/** @var RedisQueueSender $manager */
		$manager = QueueManager::create()
			->setSender(new RedisQueueSender())
			->sender($send)
            ->setDataForSend((string) \time());

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
