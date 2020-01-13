<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id', 'sender', 'reciver','text'
    ];
}
