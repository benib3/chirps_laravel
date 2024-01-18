<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'chirp_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['pivot',  'created_at', 'updated_at'];

    public function chirp() {
        return $this->belongsTo(Chirp::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function insert($user_id, $chirp_id) {
        $this->user_id = $user_id;
        $this->chirp_id = $chirp_id;
        $this->created_at = now();
        $this->save();
    }



}
