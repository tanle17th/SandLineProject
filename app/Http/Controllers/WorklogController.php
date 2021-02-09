<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worklog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Service;
use App\Exports\WorklogsExport;
use Maatwebsite\Excel\Facades\Excel;

class WorklogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $is_admin = Auth::user()->role == 'admin';

        if ($is_admin) {
            // Get data from databases
            $worklogs = Worklog::whereNotNull('endtime')->latest()->paginate(50);
            // $worklogs = Worklog::orderBy('name', 'desc')->get();
            // $worklogs = Worklog::orderBy('name')->get();
            $onGoingWorklogs = Worklog::whereNull('endtime')->latest()->get();
        } else {
            $worklogs = Worklog::where('user_id', Auth::user()->id)
                ->whereNotNull('endtime')
                ->latest()->paginate(50);
            $onGoingWorklogs = Worklog::where('user_id', Auth::user()->id)
                ->whereNull('endtime')
                ->latest()->get();
        }

        return view('worklogs.index', [
            'worklogs' => $worklogs,
            'is_admin' => $is_admin,
            'onGoingWorklogs' => $onGoingWorklogs
        ]);
    }

    public function worklogsOfWorker($worker_id)
    {
        $is_admin = Auth::user()->role == 'admin';

        $worklogs = Worklog::where('user_id', $worker_id)
            ->whereNotNull('endtime')
            ->latest()->paginate(0);
        $onGoingWorklogs = Worklog::where('user_id', $worker_id)
            ->whereNull('endtime')
            ->latest()->get();

        $worker = User::findOrFail($worker_id);

        return view('worklogs.index', [
            'worklogs' => $worklogs,
            'is_admin' => $is_admin,
            'onGoingWorklogs' => $onGoingWorklogs,
            'worker' => $worker,
        ]);
    }

    public function worklogsFilteredByDate()
    {
        $is_admin = Auth::user()->role == 'admin';

        $fromdate = request('fromdate');
        $todate = request('todate');

        $from = date($fromdate);
        $to = date($todate);

        if ($from == $to) {
            $worklogs = Worklog::whereDate('starttime', '=', $from)
                ->whereNotNull('endtime')
                ->paginate(0);
        } else {
            $worklogs = Worklog::whereDate('starttime', '>=', $from)
                ->whereDate('starttime', '<=', $to)
                ->whereNotNull('endtime')
                ->paginate(0);
        }

        return view('worklogs.index', [
            'worklogs' => $worklogs,
            'is_admin' => $is_admin
        ]);
    }

    public function edit($id)
    {
        // use $id to query the db
        $worklog = Worklog::findOrFail($id);

        $locations = Location::all();
        $services = Service::all();

        return view('worklogs.edit', [
            'worklog' => $worklog,
            'locations' => $locations,
            'services' => $services
        ]);
    }

    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();

        // Find a previous worklog if any found, then worker is punching-out, otherwise he/she is punching-in
        $previousWorklog = Worklog::where([
            ['user_id', Auth::user()->id],
            ['endtime', null]
        ])->first();

        return view('worklogs.create', [
            'locations' => $locations,
            'services' => $services,
            'previousWorklog' => $previousWorklog
        ]);
    }

    public function store()
    {

        // Find a previous worklog if any found, then worker is punching-out, otherwise he/she is punching-in
        $previousWorklog = Worklog::where([
            ['user_id', Auth::user()->id],
            ['endtime', null]
        ])->first();

        if (is_null($previousWorklog)) {
            // Worker is punching-in

            request()->validate([
                'worklogdate' => 'required',
                'timer' => 'required',
                'sitelocation' => 'required'
            ]);

            $worklog = new Worklog();

            $worklog->user_id = Auth::user()->id;
            $worklog->location_id = request('sitelocation');
            $worklog->starttime = request('worklogdate') . " " . request('timer');

            $worklog->save();

            return redirect(route('worklogs.create'))->with('msg', 'Successfully punched-in');
        } else {
            // Worker is punching-out

            request()->validate([
                'worklogdate' => 'required',
                'timer' => 'required',
                'servicesperformed' => 'required'
            ]);

            $previousWorklog->endtime = request('worklogdate') . " " . request('timer');
            $previousWorklog->comment = request('comment');

            $previousWorklog->save();

            // Adding services
            $previousWorklog->services()->sync(request('servicesperformed'));

            return redirect(route('worklogs.list'))->with('msg', 'New worklog added');
        }
    }

    public function update($id)
    {

        // request()->validate([
        //     'worklogdate' => 'required',
        //     'starttime' => 'required',
        //     'sitelocation' => 'required',
        //     'endtime' => 'required',
        //     'servicesperformed' => 'required'
        // ]);

        $worklog = Worklog::findOrFail(request('id'));

        $worklog->location_id = request('sitelocation');
        $worklog->starttime = request('worklogdatestart') . " " . request('starttime');
        if (!empty(request('worklogdateend'))) {
            $worklog->endtime = request('worklogdateend') . " " . request('endtime');
        }
        $worklog->comment = request('comment');

        $worklog->save();

        // Adding services
        $worklog->services()->sync(request('servicesperformed'));

        return redirect(route('worklogs.list'))->with('msg', 'Worklog updated');
    }

    public function delete($id)
    {

        $worklog = Worklog::findOrFail($id);
        $worklog->delete();

        return redirect(route('worklogs.list'))->with('msg', 'Worklog deleted');
    }

    public function export()
    {
        return Excel::download((new WorklogsExport), 'Worklogs.xlsx');
    }
}
