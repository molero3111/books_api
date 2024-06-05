<?php

namespace App\Listeners;

use App\Events\BookProcessed;
use App\Jobs\ProcessBookCountUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBookCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookProcessed $event): void
    {
        ProcessBookCountUpdate::dispatch($event->author);
    }
}
