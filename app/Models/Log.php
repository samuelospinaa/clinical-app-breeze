<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
       "action",
       "table_name",
       "row_id",
       "user_id",
       "old_data",
       "new_data",
    ];
}
