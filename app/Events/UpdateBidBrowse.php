<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateBidBrowse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $type;

    public function __construct($type ,$id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return ['bid-browse-'.$this->type];
    }

    public function broadcastAs()
    {
        return 'update-bid';
    }
}