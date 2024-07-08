<?php

namespace App\Brokers\RabbitMQ;

use App\Brokers\RabbitMQ\Service\Exchange;
use App\Brokers\RabbitMQ\Service\Queue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    protected static ?Queue    $queue = null;
    protected static ?Exchange $exchange = null;

    public static function onQueue() : Queue
    {
        if(is_null(static::$queue))
            static::$queue = new Queue();

        return static::$queue;
    }

    public static function onExchange() : Exchange
    {
        if(is_null(static::$exchange))
            static::$exchange = new Exchange();

        return static::$exchange;
    }
}
