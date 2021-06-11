<?php

namespace glasswalllab\keypayconnector\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ResponseReceived
{
    use Dispatchable, SerializesModels;

    public $response;

    public function __construct($response)
    {
        $this->response = $response;
    }
}