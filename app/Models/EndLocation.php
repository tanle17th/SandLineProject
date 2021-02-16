<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndLocation extends Model
{
    use HasFactory;

    // Each location record will be seperated by default.
    // Use this function to merge every columns to be only one single location row
    public function fullLocation()
    {
        return join(", ", array(
            $this->address,
            $this->city,
            $this->province,
            $this->zipcode,
            $this->country,
        ));
    }

    /**
     * End Location has relationship (1-1) with Time card.
     * Therefore, get the timecard for a specific end location and store
     * using belongsTo.
     */
    public function timecards()
    {
        return $this->belongsTo(Timecard::class);
    }
}
