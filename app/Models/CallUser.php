<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallUser extends Model
{
    use HasFactory;
    protected $table = "call_user";
    protected $guarded = [];

    public function getProfilePhotoUrlAttribute()
        {
            if ($this->profile_photo_path) {
                return asset('storage/' . $this->profile_photo_path);
            }

            return $this->profile_photo_path;
        }
}
