<?php

namespace App\Models;

use App\app\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class CustomPersonalAccessToken extends Model
{
    use HasUlid;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'name',
        'tokenable_type',
        'tokenable_id',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];
}
