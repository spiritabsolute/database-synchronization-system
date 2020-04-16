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
		$exchange = 'sync';
		$queue = $this->config['queue'];

		$channel = $this->connection->channel();

		$channel->queue_declare($queue, false, true, false, false);
		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, true, true);
		$channel->queue_bind($queue, $exchange);

		$syncQueue = $this->syncDataManager->getQueue();

		foreach ($syncQueue as $queueRow)
		{
			$queueRow['routing_key'] = $this->config['target_queue'];
			echo $queueRow['entity_type'].': '.$queueRow['name'].'->'.PHP_EOL;
			$message = new AMQPMessage(json_encode($queueRow), ['content_type' => 'application/json']);
			$channel->basic_publish($message, $exchange);
		}

		$channel->close();
		$this->connection->close();
	}

	public function consume()
	{
		$exchange = 'sync';
		$queue = $this->config['target_queue'];
		$consumerTag = $this->config['consumer'];

		$channel = $this->connection->channel();
		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, true, true);
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

		if ($queueRow['routing_key'] == $message->delivery_info['consumer_tag'])
		{
			echo $queueRow['entity_type'].': '.$queueRow['name'].'<-'.PHP_EOL;
			$this->syncDataManager->consumeQueue($queueRow);
			$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
		}
	}

	public function shutdown($channel, $connection)
	{
		$channel->close();
		$connection->close();
	}
}