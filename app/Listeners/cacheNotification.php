<?php

namespace App\Listeners;

use App\Events\MovieFetchedFromCache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class cacheNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MovieFetchedFromCache  $event
     * @return void
     */
    public function handle(MovieFetchedFromCache $event)
    {
        //Movie was fetched from cache Log event notification in log file
        \Log::info("Movie Fetched From Cache: ".$event->movieId);
    }
}
