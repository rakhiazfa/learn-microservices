<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume-messages';

    /**
     * Execute the console command.
     */
    public function handle(RabbitMQService $rabbitMQService)
    {
        $rabbitMQService->consume('events', function (AMQPMessage $message) {
            $this->info('Routing Key : ' . $message->getRoutingKey());
            $this->info('Message : ' . $message->getBody());
            $this->newLine();
        });
    }
}
