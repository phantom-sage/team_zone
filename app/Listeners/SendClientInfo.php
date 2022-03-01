<?php

namespace App\Listeners;

use App\Events\NewProjectCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendClientInfo
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
     * @param NewProjectCreated $event
     * @return void
     */
    public function handle(NewProjectCreated $event)
    {
        $client_email = $event->project->owner->email ?? null;
        Mail::to($client_email)
        ->send(new \App\Mail\NewProjectCreated($event->project));
    }
}
