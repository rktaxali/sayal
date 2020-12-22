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
        'created_user_id',
        'created_at',
    ];
}
