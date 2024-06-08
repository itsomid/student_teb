<?php

namespace App\Brokers\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    private $channel;
    private $data;
    private $exchange;
    private $callback_queue;
    private $exchangeType= 'topic';
    private $routingKey = 'castle';
    private $encode = true;
    private $rabbitMqChannel;
    private $rabbitMqConnection;
    private static $_instance = null;
    private $response;
    private $corr_id;

    private function __construct () { }


    public static function onChannel($channel)
    {
        if (self::$_instance === null  || (self::$_instance != null && is_null(self::$_instance->rabbitMqConnection))) {
            self::$_instance = new self;
            $instance= self::$_instance;
            $instance->channel = $channel;
            $instance->openChannel();
        }
        $instance= self::$_instance;
        $instance->channel = $channel;

        return $instance;
    }

    public static function onExchange($exchange)
    {
        if (self::$_instance === null || (self::$_instance != null && is_null(self::$_instance->rabbitMqConnection))) {
            self::$_instance = new self;
            $instance= self::$_instance;
            $instance->exchange = $exchange;
            $instance->openChannel();
        }
        $instance= self::$_instance;
        $instance->exchange = $exchange;
        return $instance;
    }

    public function withTopicType()
    {
        $this->exchangeType = 'topic';
        return $this;
    }
    public function withDirectType()
    {
        $this->exchangeType = 'direct';
        return $this;
    }

    public function setRoutingKey($key)
    {
        $this->routingKey = $key;
        return $this;
    }

    public function setData($data)
    {
        $data = $this->encode
            ? json_encode($data)
            : $data;

        $this->data= $data;
        return $this;
    }

    public function withoutEncoding(){
        $this->encode = false;
        return $this;
    }

    public function dispatch() {
        if (is_null($this->exchange)) {
            $msg = new AMQPMessage($this->data);
            $this->rabbitMqChannel->basic_publish($msg,'', $this->channel);
        }

        if (is_null($this->channel)) {
            $msg = new AMQPMessage($this->data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
            $this->rabbitMqChannel->basic_publish($msg, $this->exchange, $this->routingKey);
        }
    }

    public function RPC() {
        $this->rabbitMqChannel->basic_consume(
            $this->callback_queue,
            '',
            false,
            true,
            false,
            false,
            array(
                $this,
                'onResponse'
            )
        );
        return $this;
    }

    public function onResponse($rep)
    {
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    public function response()
    {
        return $this->response;
    }

    public function call()
    {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            $this->data,
            array(
                'correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue
            )
        );
        $this->rabbitMqChannel->basic_publish($msg, '',$this->channel);
        while (!$this->response) {
            $this->rabbitMqChannel->wait();
        }
        return $this;
    }

    public function openChannel()
    {
        $this->rabbitMqConnection = new AMQPStreamConnection(
            config('queue.connections.rabbitmq.host'),
            config('queue.connections.rabbitmq.port'),
            config('queue.connections.rabbitmq.login'),
            config('queue.connections.rabbitmq.password')
        );
        $channel = $this->rabbitMqConnection->channel();

        if (is_null($this->channel))
            $channel->exchange_declare($this->exchange, $this->exchangeType, false, true, false);

        if (is_null($this->exchange))
            list($this->callback_queue, ,) = $channel->queue_declare($this->channel, false, true, false, false);

        $this->rabbitMqChannel= $channel;
        return $channel;
    }

}
