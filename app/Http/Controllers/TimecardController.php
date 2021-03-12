<?php

namespace App\Http\Controllers;

use App\Models\EndLocation;
use App\Models\StartLocation;
use App\Models\Timecard;
use App\Models\User;
use Illuminate\Http\Request;
use Facade\FlareClient\Time\Time;
use App\Http\Controllers\Carbon;
use Carbon\Carbon as CarbonCarbon;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

//use Illuminate\Support\Facades\Auth;

class TimecardController extends Controller
{

    /**
     * This use middleware function to keep track of application's user
     * Only user HAS ACCOUNT in the application (Having credential in User table)
     * can access this application
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This method returns the List of all Timecards for both Worker and Admin side
     * This method implements every URL that requires to view LIST OF TIMECARDS
     * (Implements both: + When user clicks on Completed Timecard
     *                   + When user filter the Timecard)
     * URLs implemented:
     * + Route::get('/timecards', [TimecardController::class, 'index'])->name('timecards.list');
     * + Route::post('/timecards/filterByNameAndDate', [TimecardController::class, 'index'])->name('timecards.filtered.admin')->middleware('auth.admin');
     * + Route::post('/timecards/filterByDate', [TimecardController::class, 'index'])->name('timecards.filtered.worker');
     *
     */
    public function index()
    {
        // Determine the role of the user:
        $is_admin = Auth::user()->role == 'admin';

        // These three variables are filled only when filter Timecards are implemented
        // Ex: When admin filter the List by worker's name, request('name') is set
        // Ex: When worker/admin filter the List by Date, request('fromDate') and request('toDate') are set
        $select_worker = request('name');
        $fromDate = request('fromDate');
        $toDate = request('toDate');

        // CURRENT USER = ADMIN
        if ($is_admin) {

            // Get all worker's name to display on the filter select column on Admin side
            $allWorkers = User::where('role', 'worker')->select('name')->distinct()->get()->pluck('name');

            // --------------------------------------- Filter conditional for Admin ----------------------------------------------

            // FIRST:
            // if all filter condition (worker/fromDate/toDate) are selected -> Get data and display based on all conditions
            if (!empty($select_worker) and !empty($fromDate) and !empty($toDate)) {
                $allTimecards = Timecard::where('user_id', User::where('name', $select_worker)->first()->id)
                    ->whereNotNull('end_time')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->latest()->paginate(50);
            }
            // SECOND:
            // if only worker filter is selected (fromDate and toDate is empty) -> Get all timecards of that Worker and display
            elseif (!empty($select_worker) and (empty($fromDate) or empty($toDate))) {
                $allTimecards = Timecard::where('user_id', User::where('name', $select_worker)->first()->id)
                    ->whereNotNull('end_time')
                    ->latest()->paginate(50);
            }
            // THIRD:
            // if worker is not selected (empty) but fromDate and toDate is filtered -> Get timecards based on that range of day and display
            elseif (empty($select_worker) and !empty($fromDate) and !empty($toDate)) {
                $allTimecards = Timecard::whereNotNull('end_time')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->latest()->paginate(50);
            }
            // FOURTH:
            // if none of the condition above is true -> Get ALL timecards of and display
            else {
                $allTimecards = Timecard::whereNotNull('end_time')->latest()->paginate(50);
            }
            // Get all on-going timecards:
            $onGoingTimecards = Timecard::whereNull('end_time')->latest()->get();
        }

        // CURRENT USER = WORKER
        else {
            $allWorkers = Auth::user()->name;
            // --------------------------------------- Filter conditional for Worker ----------------------------------------------

            // FIRST:
            // if BOTH fromDate and toDate are filter -> Get all Timecards based on that range and display
            if (!empty($fromDate) and !empty($toDate)) {
                $allTimecards = Timecard::where('user_id', Auth::user()->id)
                    ->whereNotNull('end_time')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->latest()->paginate(50);
            }

            // SECOND:
            // if NONE fromDate and toDate are filter -> Get all Timecards
            else {
                $allTimecards = Timecard::where('user_id', Auth::user()->id)
                    ->whereNotNull('end_time')
                    ->latest()->paginate(50);
            }
            // Get all on-going timecards:
            $onGoingTimecards = Timecard::where('user_id', Auth::user()->id)
                ->whereNull('end_time')
                ->latest()->get();
        }

        return view('timecards.index', [
            'allTimecards' => $allTimecards,
            'is_admin' => $is_admin,
            'onGoingTimecards' => $onGoingTimecards,
            'eachIndex' => '1',
            'allWorkers' => $allWorkers,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'select_worker' => $select_worker
        ]);
    }


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

        //if startOfWorkday is null, WORKER = STARTING
        if (is_null($startOfWorkday)) {
            // Validate the data returned from create.blade:
            request()->validate([
                'timecarddate' => 'required',
                'timer' => 'required',
                'start_location' => 'required'
            ]);

            // Create new Timecard to be saved to the database:
            $timecard = new Timecard();
            // Initialize $timecard with "start of workday" data POST from create.blade:
            $timecard->user_id = Auth::user()->id;
            $timecard->date = request('timecarddate');
            // Start Time in database is type DateTime, so it needs both values
            $timecard->start_time = request('timecarddate') . " " . request('timer');
            // Location is basically just a string (VARCHAR type in database)
            $timecard->start_location = request('start_location');
            $timecard->comment = request('start_comment');

            // Step to save new data into the database:
            $timecard->save();

            // Redirect the route to timecards.create
            // Log the message:
            return redirect(route('timecards.list'))->with('msg', 'Successfully start the workday!');
        }

        //if startOfWorkday is not null, WORKER = ENDING
        else {
            // Validate the data returned from create.blade:
            request()->validate([
                'timecarddate' => 'required',
                'timer' => 'required',
                'end_location' => 'required'
            ]);

            // Initialize $timecard with "end" data POST from create.blade:
            // End Time in database is type DateTime, so it needs both values
            $startOfWorkday->end_time = request('timecarddate') . " " . request('timer');
            // Location is basically just a string (VARCHAR type in database)
            $startOfWorkday->end_location = request('end_location');
            $startOfWorkday->comment = request('end_comment');

            // Calculate total hours of working using diff method
            // Pass into $startOfWorkday variable too:
            error_log($start_time_to_cal = CarbonCarbon::parse($startOfWorkday->start_time));
            error_log($end_time_to_cal = CarbonCarbon::parse($startOfWorkday->end_time));
            $startOfWorkday->total_hours = $start_time_to_cal->diff($end_time_to_cal)->format('%H:%I:%S');

            // Step to save new data into the database:
            $startOfWorkday->save();

            // Redirect the route to dashboard
            // Log the message:
            return redirect(route('timecards.list'))->with('msg', 'Successfully end the workday!!!');
        }
    }

    /**
     * This method get called in route->name('timecards.edit');
     * Return the page with modified Timecard's ID
     */
    public function edit($id)
    {
        // Retrieve timecard with the ID
        $timecard = Timecard::findOrFail($id);
        // Pass the timecard to edit.blade view
        return view('timecards.edit', [
            'timecard' => $timecard
        ]);
    }

    /**
     * This method get called in route->name('timecards.update');
     * Get the update form (update information), and update the timecard in the database with NEW DATA
     */
    public function update()
    {
        // Retrieve update timecard using the ID
        $updateTimecard = Timecard::findOrFail(request('id'));
        // Set NEW DATE
        $updateTimecard->date = request('end_date');
        // Set NEW START TIME
        $start_time_to_cal = $updateTimecard->start_time = request('start_date') . " " . request('start_time');
        // Set NEW END TIME
        if (!empty(request('end_time'))) {
            $end_time_to_cal = $updateTimecard->end_time = request('end_date') . " " . request('end_time');
        }
        // Set NEW COMMENT
        $updateTimecard->comment = request('comment');
        // If both START TIME and END TIME are not empty:
        // Calculate the NEW total working hours based on NEW START TIME and END TIME
        if (!empty($start_time_to_cal) and !empty($end_time_to_cal)) {
            error_log($start_time_to_cal = CarbonCarbon::parse($start_time_to_cal));
            error_log($end_time_to_cal = CarbonCarbon::parse($end_time_to_cal));
            $updateTimecard->total_hours = $start_time_to_cal->diff($end_time_to_cal)->format('%H:%I:%S');
        }

        // SAVE new update Timecard to the database
        $updateTimecard->save();

        // Redirect the route to the list
        // Log the message:
        return redirect(route('timecards.list'))->with('msg', 'Time Card updated successfully!');
    }

    /**
     * This method get called in route->name('timecards.delete');
     * Get the Timecard's id, and delete it from the database
     */
    public function delete($id)
    {
        // Retrieve delete timecard using the ID
        $timecard = Timecard::findOrFail($id);
        // Call delete() method to delete that Timecard in the database
        $timecard->delete();

        // Redirect the route to the list
        // Log the message:
        return redirect(route('timecards.list'))->with('msg', 'Time Card deleted');
    }
}
