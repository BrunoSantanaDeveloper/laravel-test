<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'dob', 'gender'];

    /**
     * Get the reports associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}
