{{-- This blade view is basically just a placeholder to export data --}}
{{-- to Excel using FromView method. Data is retrieved in export class --}}
{{-- and passed into this view --}}
<table>
    <thead>
        <tr>
            <th><b>Employee Name</b></th>
            <th><b>Date</b></th>
            <th><b>Start Work</b></th>
            <th><b>End Work</b></th>
            <th><b>Hours</b></th>
            <th><b>Minutes</b></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($exportTimecards as $exportTimecard)
            <tr>
                <td>{{ $exportTimecard->worker->name }}</td>
                <td>{{ $exportTimecard->date }}</td>
                <td>{{ explode(' ', $exportTimecard->start_time)[1] }}</td>
                <td>{{ explode(' ', $exportTimecard->end_time)[1] }}</td>
                <td style="display: table-cell; text-align:right; vertical-align: middle">
                    <span class="badge badge-pill badge-light">{{ explode(':', $exportTimecard->total_hours)[0] }}</span>
                </td>
                <td style="display: table-cell; text-align:right; vertical-align: middle;">
                    <span class="badge badge-pill badge-light">{{ explode(':', $exportTimecard->total_hours)[1] }}</span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
