<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        //$timecards = Timecard::all();

        // return view('timecard.create', [
        //     'timecards' => $timecards
        // ]);
        return view('incidents.create');
    }
}
