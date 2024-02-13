<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $fillable = ['from_id', 'to_id', 'text', 'is_read'];

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

    public function setRead()
    {
        $this->is_read = true;
        $this->save();
    }
}
