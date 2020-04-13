<?php
namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class SyncManager
{
	private $connection;

	private $syncDataManager;

	private $dbNamespace;

	public function __construct($config, SyncDataManager $syncDataManager)
	{
		$this->connection = new AMQPStreamConnection(
			$config['host'],
			$config['port'],
			$config['user'],
			$config['password']
		);
		$this->syncDataManager = $syncDataManager;
	}

	public function send()
	{
		$exchange = 'exchange';

		$channel = $this->connection->channel();

		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, false, true);

		$outputData = $this->syncDataManager->getOutputData();

		$msg = new AMQPMessage($outputData, ['content_type' => 'application/json']);
		$channel->basic_publish($msg, $exchange);

		$channel->close();
		$this->connection->close();
	}

	public function receive()
	{
		$exchange = 'exchange';
		$queue = 'base';
		$consumerTag = 'consumer';

		$channel = $this->connection->channel();
		$channel->queue_declare($queue, false, true, false, false);
		$channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, false, true);
		$channel->queue_bind($queue, $exchange);
		$channel->basic_consume($queue, $consumerTag, false, false, false, false, [$this, 'processMessage']);

		register_shutdown_function([$this, 'shutdown'], $channel, $this->connection);

		while ($channel ->is_consuming())
		{
			$channel->wait();
		}
	}

	public function processMessage($message)
	{
		$inputData = json_decode($message->body, true);

		while ($entityData = array_pop($inputData))
		{
			//todo sync log
			echo $entityData['name'].PHP_EOL;

			if ($this->syncDataManager->addInputData($entityData))
			{

			}
		}

		$message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);

		$message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
	}

	public function shutdown($channel, $connection)
	{
		$channel->close();
		$connection->close();
	}
}