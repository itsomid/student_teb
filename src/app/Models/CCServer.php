<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCServer extends Model
{
    use HasFactory;
    protected $table = 'cc_servers';

    protected $fillable = ['name', 'url'];
}
