<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WartaJemaat extends Model
{
    use HasFactory;
    protected $table = 'warta';
    public $timestamps = false;

    protected $guarded  = [];
}
