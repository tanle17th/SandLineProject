<?php

namespace App\Http\Controllers;

use App\Models\EndLocation;
use App\Models\StartLocation;
use App\Models\Timecard;
use App\Models\User;
use Illuminate\Http\Request;
use Facade\FlareClient\Time\Time;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Support\Facades\Auth;

class TimecardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $timecards = Timecard::all();

    //     return view('timecard.create', [
    //         'timecards' => $timecards
    //     ]);
    // }

    /**
     * This method get called in route->name('timecards.create');
     */
    public function create()
    {
        // Loop through Timecard table to find timecards
        // which has a specific user_id
        // If it is foundable, store in startOfWorkday
        // and pass to timecard/create.blade.php,
        // it means worker is about to end the workday
        // Otherwise, worker is about to start the workday
        $startOfWorkday = Timecard::where([
            ['user_id', Auth::user()->id],
            ['end_time', null]
        ])->first();

        return view('timecards.create', [
            'startOfWorkday' => $startOfWorkday
        ]);
    }

    /**
     * This method get called in route->name('timecards.store');
     * Store new data into the database
     */
    public function store()
    {

        // Find a "Start of Workday" if any found,
        // then worker is about to end, otherwise he/she is about to start.
        $startOfWorkday = Timecard::where([
            ['user_id', Auth::user()->id],
            ['end_time', null]
        ])->first();

        //if startOfWorkday is null, means worker is starting:
        if (is_null($startOfWorkday)) {
            // Validate the data returned from create.blade:
            request()->validate([
                'timecarddate' => 'required',
                'timer' => 'required',
                //'start_location' => 'required'
            ]);

            // Create new Timecard to be saved to the database:
            $timecard = new Timecard();
            // Initialize $timecard with "start of workday" data POST from create.blade:
            $timecard->user_id = Auth::user()->id;
            $timecard->date = request('timecarddate');
            $timecard->start_time = request('timecarddate') . " " . request('timer');

            // This is just draft for location
            // Get the location made manually to set the Ids:
            //$timecard->location = request('start_location');
            $timecard->start_location_id = StartLocation::where('id', 1)->latest()->value('id');
            $timecard->end_location_id = EndLocation::where('id', 1)->latest()->value('id');
            //$timecard->end_location_id = $endLocation->id;

            $timecard->comment = request('start_comment');
            // Step to save new data into the database:
            error_log($timecard);
            $timecard->save();
            // Redirect the route to timecards.create
            // Log the message:
            return redirect(route('timecards.create'))->with('msg', 'Successfully start the workday!!!');
        }

        //if startOfWorkday is not null, means worker is starting:
        else {
            // Validate the data returned from create.blade:
            request()->validate([
                'timecarddate' => 'required',
                'timer' => 'required',
                //'end_location' => 'required'
            ]);

            // Initialize $timecard with "end" data POST from create.blade:
            $startOfWorkday->end_time = request('timecarddate') . " " . request('timer');
            //$startOfWorkday->location = request('end_location');
            $startOfWorkday->comment = request('end_comment');
            // Step to save new data into the database:
            $startOfWorkday->save();
            // Redirect the route to dashboard
            // Log the message:
            return redirect(route('dashboard'))->with('msg', 'Successfully end the workday!!!');
        }
    }
}
