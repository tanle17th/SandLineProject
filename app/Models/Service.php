<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The worklogs that belong to this service.
     */
    public function worklogs()
    {
        return $this->belongsToMany(Worklog::class);
    }
}
