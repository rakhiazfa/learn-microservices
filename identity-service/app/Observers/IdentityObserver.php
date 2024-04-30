<?php

namespace App\Observers;

use App\Models\Identity;
use App\Services\RabbitMQService;

class IdentityObserver
{
    public function __construct(private RabbitMQService $rabbitMQService)
    {
        // 
    }

    /**
     * Handle the Identity "created" event.
     */
    public function created(Identity $identity): void
    {
        $payload = [
            'message' => 'Successfully created a new identity',
            'identity' => $identity->toArray(),
        ];

        $this->rabbitMQService->publish('events', 'identities.events.created', json_encode($payload));
    }

    /**
     * Handle the Identity "updated" event.
     */
    public function updated(Identity $identity): void
    {
        $payload = [
            'message' => 'Successfully updated identity',
            'identity' => $identity->toArray(),
        ];

        $this->rabbitMQService->publish('events', 'identities.events.updated', json_encode($payload));
    }

    /**
     * Handle the Identity "deleted" event.
     */
    public function deleted(Identity $identity): void
    {
        $payload = [
            'message' => 'Successfully deleted identity',
            'identity' => $identity->toArray(),
        ];

        $this->rabbitMQService->publish('events', 'identities.events.deleted', json_encode($payload));
    }

    /**
     * Handle the Identity "restored" event.
     */
    public function restored(Identity $identity): void
    {
        $payload = [
            'message' => 'Successfully restored identity',
            'identity' => $identity->toArray(),
        ];

        $this->rabbitMQService->publish('events', 'identities.events.restored', json_encode($payload));
    }

    /**
     * Handle the Identity "force deleted" event.
     */
    public function forceDeleted(Identity $identity): void
    {
        $payload = [
            'message' => 'Successfully deleted identity',
            'identity' => $identity->toArray(),
        ];

        $this->rabbitMQService->publish('events', 'identities.events.forceDeleted', json_encode($payload));
    }
}
