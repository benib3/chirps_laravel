<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'chirp_id',
        'user_id',
        'comment',
    ];

      /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['pivot',  'updated_at', 'deleted_at'];

    public function chirp() {
        return $this->belongsTo(Chirp::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
