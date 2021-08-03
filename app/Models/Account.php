<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'username', 'password', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
