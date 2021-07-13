<?php

namespace glasswalllab\keypayconnector\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APICall extends Model
{
    use HasFactory;

    protected $table = 'api_calls';

    protected $fillable = [
        'request','response',
    ];
}