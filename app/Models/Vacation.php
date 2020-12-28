<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $table = 'vacation';

    protected $fillable = [
        'start_date',
        'end_date',
        'year',
        'user_id',
        'create_user_id',
        'created_at',
        'updated_at',
    ];
}
