<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    /**
     * Incident has a many to one relation with user
     * Therefore get the user id referencing worker associated with an incident 
     * and store same in user_id column of incident table
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // This is just another method to call by a worker rather than user for clarity reason
    public function worker()
    {
        return $this->user();
    }

    /**
     * Incident has a many to one relation with location
     * Therefore get the location id referencing location of an incident 
     * and store same in location_id column of incident table
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
