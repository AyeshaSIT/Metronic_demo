<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsProcessed extends Model
{
    protected $table = "jobs_processed";
    protected $guarded = [];
    use HasFactory;
}
