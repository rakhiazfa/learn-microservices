<?php

namespace App\Services;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class RabbitMQService
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var AMQPChannel
     */
    private AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.username'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
    }

    /**
     * @param string $exchange
     * @param string $routingKey
     * @param string $message
     * @param array $headers
     * 
     * @return void
     */
    public function publish(string $exchange, string $routingKey, string $message, array $headers = []): void
    {
        $message = new AMQPMessage($message);
        $applicationHeaders = new AMQPTable();

        foreach ($headers as $key => $value) {
            $applicationHeaders->set($key, $value);
        }

        $message->set('application_headers', $applicationHeaders);

        $this->channel->basic_publish($message, $exchange, $routingKey);
    }

    /**
     * @param string $queue
     * @param callable $callback
     * 
     * @return void
     */
    public function consume(string $queue, callable $callback): void
    {
        $this->channel->basic_consume($queue, '', false, true, false, false, $callback);
        $this->channel->consume();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
