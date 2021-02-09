<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
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

    /**
     * The services that belong to this worklog.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Check if provided service performed on this worklog.
     * Return true if performed, otherwise false
     */
    public function checkServicePerformed($service)
    {
        return $this->services()->pluck('service_id')->contains($service->id);
    }
}
