<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

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
     * Get the worklogs for this location.
     */
    public function worklogs()
    {
        return $this->hasMany(Worklog::class);
    }
}
