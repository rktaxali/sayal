<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
	
	  protected $fillable = [
        'start_date',
        'prepared_user_id',
        'approved_user_id',
        'revised_user_id',
    ];
	
}
