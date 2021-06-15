<?php

namespace glasswalllab\keypayconnector\Listeners;

use glasswalllab\keypayconnector\Events\ResponseReceived;

class UpdateResponse
{
    public function handle(ResponseReceived $event)
    {
        dd(json_decode($event->getBody()->getContents()));
    }
}