<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'users_detail';

    protected $fillable = [
        'users_id',
        'firstname',
        'lastname',
        'middlename'
        
    ];


    public function usersDetails(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
