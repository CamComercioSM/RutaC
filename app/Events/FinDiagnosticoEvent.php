<?php

namespace App\Events;

use App\Models\Diagnostico;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FinDiagnosticoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $diagnostico;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Diagnostico $diagnostico
     */
    public function __construct(User $user, Diagnostico $diagnostico)
    {
        $this->user = $user;
        $this->diagnostico = $diagnostico;
    }
}
