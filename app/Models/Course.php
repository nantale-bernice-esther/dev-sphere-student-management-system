<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Course extends Model
{
   protected $fillable = ['code', 'title', 'credit_units', 'lecturer_id'];
    
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function students(): BelongsToMany{

    return $this->belongsToMany(Student::class, 'registrations')
             ->withPivot('semester')
             ->withTimestamps();
    }
     public function registrations(): HasMany
     {
        return $this-> hasMany(Registration::class);     }
    // //
}
