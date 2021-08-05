<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $fillable = ['google_id', 'name', 'email', 'image_url', 'token'];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'owner_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id', 'id');
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthIdentifierName()
    {
        return 'google_id';
    }

    public function getAuthPassword()
    {
        return $this->token;
    }

    public function getRememberTokenName()
    {
        return 'token';
    }

    public function getRememberToken()
    {
        if (!empty($this->getRememberTokenName())) {
            return $this->{$this->getRememberTokenName()};
        }
    }

    public function setRememberToken($value)
    {
        if (!empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }
}
