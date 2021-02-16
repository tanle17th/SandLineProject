<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    use HasFactory;

    /**
     * Timecard has relationship with User.
     * Therefore, get the user for a specific Timecard and store
     * in the database for user_id column
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        return $this->user();
    }

    /**
     * Timecard has relationship with Start Location.
     * Therefore, get the start location id for a specific Timecard and store
     * in the database for start_location_id column
     */
    public function start_location()
    {
        return $this->belongsTo(StartLocation::class);
    }

    /**
     * Timecard has relationship with End Location.
     * Therefore, get the end location id for a specific Timecard and store
     * in the database for end_location_id column
     */
    public function end_location()
    {
        return $this->belongsTo(EndLocation::class);
    }
}
