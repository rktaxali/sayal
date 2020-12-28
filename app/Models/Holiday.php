<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = 'holiday';

    protected $fillable = [
        'year',
        'name',
        'date',
        'create_user_id',
        'created_at',
    ];
}
