<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 20:19
 */

$rk = new \RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers('192.168.99.1');

$topic = $rk->newTopic("test");

for ($i = 0; $i < 10; $i++) {
	$topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message $i");
	$rk->poll(0);
}

$conf = new RdKafka\Conf();

$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers("192.168.99.1");

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);

$topicConf->set('offset.store.method', 'file');
$topicConf->set('offset.store.path', sys_get_temp_dir());

$topicConf->set('auto.offset.reset', 'smallest');

$topic = $rk->newTopic("test", $topicConf);

$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

while (true) {
	$message = $topic->consume(0, 120*10000);
	switch ($message->err) {
		case RD_KAFKA_RESP_ERR_NO_ERROR:
			var_dump($message);
			break;
		case RD_KAFKA_RESP_ERR__TIMED_OUT:
			echo "Timed out\n";
			break;
		default:
			throw new \Exception($message->errstr(), $message->err);
			break;
	}
}