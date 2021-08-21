<?php

namespace App\Listeners;

use App\Mail\TraceShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TraceCreatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        dd($event);
//        Mail::to($event->details['email'])->send(new TraceShipped($event->details));
        Mail::to('jasper.agrabah@gmail.com')->send(new TraceShipped($event->details));
    }
}
