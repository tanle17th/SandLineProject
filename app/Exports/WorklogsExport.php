<?php

namespace App\Exports;

use App\Models\Worklog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

use function PHPUnit\Framework\isEmpty;

class WorklogsExport implements
    // FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    FromQuery
{
    // /**
    //  * @return \Illuminate\Support\Collection
    //  */
    // public function collection()
    // {
    //     return Worklog::whereNotNull('endtime')->get();
    // }

    public function query()
    {
        return Worklog::query()->whereNotNull('endtime');
    }

    public function map($worklog): array
    {
        // $worklog->services->dd();
        // $worklog->services->map->only(['name'])->dd();

        $services_performed = '';
        $comma = '';
        foreach ($worklog->services as $service) {
            $services_performed = $services_performed . $comma . $service->name;
            if (isEmpty($comma)) {
                $comma = ', ';
            }
        }

        return [
            $worklog->id,
            $worklog->starttime,
            $worklog->starttime,
            $worklog->endtime,
            $worklog->location->fullLocation(),
            $services_performed,
            $worklog->worker->name,
            $worklog->worker->email,
            $worklog->comment,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Date',
            'Start time',
            'End time',
            'Location',
            'Services',
            'Worker Name',
            'Worker Email',
            'Comments',
        ];
    }
}
