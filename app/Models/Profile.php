<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'dob', 'gender'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
