<?php
namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class SyncManager
{
	private $connection;
	private $config;
	private $syncDataManager;

	public function __construct(array $config, SyncQueueManager $syncDataManager)
	{
		$this->connection = new AMQPStreamConnection(
			$config['host'],
			$config['port'],
			$config['user'],
			$config['password']
		);
		$this->syncDataManager = $syncDataManager;
		$this->config = $config;
	}

	public function produce()
	{
		$exchange = 'exchange';

		$channel = $this->connection->channel();

		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, false, true);

		$queue = $this->syncDataManager->getQueue();

		foreach ($queue as $row)
		{
			echo $row['entity_type'].': '.$row['name'].'->'.PHP_EOL;
			$message = new AMQPMessage(json_encode($row), ['content_type' => 'application/json']);
			$channel->basic_publish($message, $exchange);
		}

		$channel->close();
		$this->connection->close();
	}

	public function consume()
	{
		$exchange = 'exchange';
		$queue = 'base';
		$consumerTag = 'consumer';

		$channel = $this->connection->channel();
		$channel->queue_declare($queue, false, true, false, false);
		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, false, true);
		$channel->queue_bind($queue, $exchange);
		$channel->basic_consume($queue, $consumerTag, true, false, false, false, [$this, 'processMessage']);

		register_shutdown_function([$this, 'shutdown'], $channel, $this->connection);

		while ($channel ->is_consuming())
		{
			$channel->wait();
		}
	}

	public function processMessage($message)
	{
		$queueRow = json_decode($message->body, true);

		//todo sync log
		echo $queueRow['entity_type'].': '.$queueRow['name'].'<-'.PHP_EOL;

		$this->syncDataManager->consumeQueue($queueRow);

		$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
		$message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
	}

	public function shutdown($channel, $connection)
	{
		$channel->close();
		$connection->close();
	}
}