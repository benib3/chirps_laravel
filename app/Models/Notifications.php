<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_from_id',
        'user_to_id',
        'description',
        'type',
        'read'
    ];

    protected $hidden = [ 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function from() {
        return $this->belongsTo(User::class);
    }

    public function insert($user_from_id, $user_to_id, $type, $description) {
        $this->user_from_id = $user_from_id;
        $this->user_to_id = $user_to_id;
        $this->type = $type;
        $this->description = $description;
        $this->read = false;
        $this->created_at = now();
        $this->save();
    }


}
