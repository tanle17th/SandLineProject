<?php

namespace App\Exports;

use App\Models\Timecard;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TimecardExport implements
    FromView,
    ShouldAutoSize
{

    use Exportable;

    // Protected fields for this class.
    // To take values needed for the filter and query the database again for export function,
    // use these fields
    protected $select_worker;
    protected $fromDate;
    protected $toDate;

    // Constructor
    function __construct($select_worker, $fromDate, $toDate)
    {
        $this->select_worker = $select_worker;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
     * This method implements the same logic as in index() method of TimecardController class
     * Look at TimecardController for reference
     * After querying the data again (the data is the same as what were filtered in filter function earlier),
     * pass all export Time Cards data to the placeholder view (Timecards.export) to export.
     */
    public function view(): View
    {
        if (!empty($this->select_worker) and !empty($this->fromDate) and !empty($this->toDate)) {
            $exportTimecards = Timecard::select('user_id', 'date', 'start_time', 'end_time', 'total_hours')->where('user_id', User::where('name', $this->select_worker)->first()->id)
                ->whereNotNull('end_time')
                ->where('date', '>=', $this->fromDate)
                ->where('date', '<=', $this->toDate)
                ->latest()->paginate(50);
        } elseif (!empty($this->select_worker) and (empty($this->fromDate) or empty($this->toDate))) {
            $exportTimecards = Timecard::select('user_id', 'date', 'start_time', 'end_time', 'total_hours')->where('user_id', User::where('name', $this->select_worker)->first()->id)
                ->whereNotNull('end_time')
                ->latest()->paginate(50);
        } elseif (empty($this->select_worker) and !empty($this->fromDate) and !empty($this->toDate)) {
            $exportTimecards = Timecard::select('user_id', 'date', 'start_time', 'end_time', 'total_hours')->whereNotNull('end_time')
                ->where('date', '>=', $this->fromDate)
                ->where('date', '<=', $this->toDate)->orderBy('user_id')
                ->latest()->paginate(50);
        } else {
            $exportTimecards = Timecard::select('user_id', 'date', 'start_time', 'end_time', 'total_hours')
                ->whereNotNull('end_time')
                ->latest()
                ->paginate(50);
        }
        return view('timecards.export', [
            'exportTimecards' => $exportTimecards
        ]);
    }
}
