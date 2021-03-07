<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    /**
     * Get the worker that belongs to this worklog.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // This is just another method to call by a worker rather than user
    public function worker()
    {
        return $this->user();
    }

    /**
     * Get the location of this worklog.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
