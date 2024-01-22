<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    //from message
    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    //to message
    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
