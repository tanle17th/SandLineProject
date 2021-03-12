{{-- Display the List of all Timecards --}}
{{-- Both admin and worker can reach this page --}}
{{-- Admin blocks are the first two before else condition on Col 5
     Worker blocks are the last two after else condition on Col 5 --}}
    {{-- Two blocks are:
        1/ h1 with On-Going Time Cards
        2/ h1 with All Time Cards --}}
{{-- Route(timecards.list) --}}
@extends('layouts.app')

@section('content')

<div class="container">

    @if ($is_admin)

        @if (isset($onGoingTimecards))

        <div class="container rounded border border-warning p-3 bg-red">

            <h1 class="mb-3">On-Going Time Cards</h1>

            {{-- Display successful message --}}
            @if (session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('msg') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <table class="table table-hover mt-3 border table-bordered table-striped">

                {{-- Prints out the header of the table --}}
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Start Location</th>
                    <th scope="col">End Location</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Minutes</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody>
                @if ($onGoingTimecards->isEmpty())

                <tr>
                    <th scope="row" colspan="10">Nothing to display</th>
                </tr>

                @else

                    {{-- Loops through each Timecard passing by TimecardController class
                         Display them in each td --}}
                    @foreach ($onGoingTimecards as $onGoingTimecard)
                    <tr>
                        <th scope="row">{{ $onGoingTimecard->worker->name }}</th>
                        <td>{{ $onGoingTimecard->date }}</td>
                        <td>{{ explode(' ', $onGoingTimecard->start_time)[1] }}</td>
                        <td></td>
                        <td>{{ $onGoingTimecard->start_location }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $onGoingTimecard->comment }}</td>

                        {{-- This td is for Action column of Admin --}}
                        {{-- Admin has two abilities: Modify and Delete --}}
                        <td>
                            <div class="btn-group" role="group">

                                <a href="{{ route('timecards.edit', $onGoingTimecard->id) }}">
                                    <button class="btn btn-outline-primary waves-effect px-4">
                                    <i class="fas fa-user-edit"></i>
                                    </button>
                                </a>

                                <form action="{{ route('timecards.delete', $onGoingTimecard->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger waves-effect px-4"
                                onclick="return confirm('Are you sure you want to delete this Time Card?');"><i class="fa fa-trash"></i>
                                </button>
                                </form>

                            </div>
                    </td>
                    </tr>
                    @endforeach

                @endif
                </tbody>



            </table>
        </div>

        @endif

        <div class="container rounded border border-secondary p-3 mt-3 bg-red">

            <div class="row justify-content-between">
                <div class="col-4">
                    <h1 class="mb-3">All Time Cards</h1>
                </div>
                <div class="col-4" style="text-align:end">
                <a href="{{ route('timecards.list') }}">
                    <i class="fas fa-file-excel mr-2"></i> Export All Timecards to Excel
                </a>
                </div>
            </div>

            {{-- The filter form is passed into TimecardController class (method index) --}}
        <form action="{{ route('timecards.filtered.admin') }}" method="POST">
        @csrf

            <div class="row rounded m-1 pt-2 align-items-center" style="background: #acd0ff;">
                <div class="col-sm form-group">
                    <label for="name"><strong>Select Worker:</strong></label>
                    <select name="name" id="name" class="form-control filter-select">
                        <option value="">Select name...</option>
                        @foreach ($allWorkers as $name)
                            <option value="{{ $name }}" id="name">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm form-group">
                    <label for="fromDate"><strong>From Date:</strong></label>
                    <input type="date" id="fromDate" name="fromDate" class="form-control"
                        value="">
                    @error('fromDate')
                        <span class="text-danger">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-sm form-group">
                    <label for="toDate"><strong>To Date:</strong></label>
                    <input type="date" id="toDate" name="toDate" class="form-control"
                        value="">
                    @error('toDate')
                        <span class="text-danger">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-sm">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-1"></i> Filter</button>
                </div>

            </div>
        </form>

            <br>

            {{-- This is the condition to decide this filter is for Admin --}}
            {{-- Because on Admin side, they can filter all the Timecards by
                 both DATE and NAME --}}
            {{-- The filter form is passed into TimecardController class (method index) --}}
            @if (\Request::is('timecards/filterByNameAndDate'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Filtering... </strong>
                <br> Worker:
                @if (@isset($select_worker))
                    {{ $select_worker }}
                @else
                    None
                @endif

                <br> From:
                @if (@isset($fromDate))
                    {{ $fromDate }}
                @else
                    None
                @endif

                <br> To:
                @if (@isset($toDate))
                    {{ $toDate }}
                @else
                    None
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <table class="table table-hover mt-10 border table-bordered table-striped" id="datatable">

                {{-- Prints out the header of the table --}}
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Start Location</th>
                    <th scope="col">End Location</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Minutes</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody>
                @if ($allTimecards->isEmpty())
                    <tr>
                    <td colspan="10">
                        Nothing to display
                    </td>
                    </tr>

                @else

                    {{-- Loops through each Timecard passing by TimecardController class
                         Display them in each td --}}
                    @foreach ($allTimecards as $allTimecard)
                    <tr>
                        <th scope="row">{{ $allTimecard->worker->name }}</th>
                        <td>{{ $allTimecard->date }}</td>
                        <td>{{ explode(' ', $allTimecard->start_time)[1] }}</td>
                        <td>{{ explode(' ', $allTimecard->end_time)[1] }}</td>
                        <td>{{ $allTimecard->start_location }}</td>
                        <td>{{ $allTimecard->end_location }}</td>
                        <td style="display: table-cell; text-align:center; vertical-align: middle">
                            <span class="badge badge-pill badge-light">{{ explode(':', $allTimecard->total_hours)[0] }}</span>
                        </td>
                        <td style="display: table-cell; text-align:center; vertical-align: middle;">
                            <span class="badge badge-pill badge-light">{{ explode(':', $allTimecard->total_hours)[1] }}</span>
                        </td>
                        <td>{{ $allTimecard->comment }}</td>

                        {{-- This td is for Action column of Admin --}}
                        {{-- Admin has two abilities: Modify and Delete --}}
                        <td>
                                <div class="btn-group" role="group">

                                    <a href="{{ route('timecards.edit', $allTimecard->id) }}">
                                        <button class="btn btn-outline-primary waves-effect px-4">
                                        <i class="fas fa-user-edit"></i>
                                        </button>
                                    </a>

                                    <form action="{{ route('timecards.delete', $allTimecard->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger waves-effect px-4"
                                    onclick="return confirm('Are you sure you want to delete this Time Card?');"><i class="fa fa-trash"></i>
                                    </button>
                                    </form>

                                </div>
                        </td>
                    </tr>
                    @endforeach

                @endif
                </tbody>

            </table>
        </div>


    @else

        @if (isset($onGoingTimecards))

        <div class="container rounded border border-warning p-3 bg-red">

            <h1 class="mb-3">On-Going Time Cards</h1>

            {{-- Display successful message --}}
            @if (session()->has('msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('msg') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-hover mt-3 border table-bordered table-striped">

                {{-- Prints out the header of the table --}}
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Start Location</th>
                    <th scope="col">End Location</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Minutes</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody>
                @if ($onGoingTimecards->isEmpty())
                    <tr>
                    <td colspan="9">
                        Nothing to display
                    </td>
                    </tr>

                @else

                    {{-- Loops through each Timecard passing by TimecardController class
                         Display them in each td --}}
                    @foreach ($onGoingTimecards as $onGoingTimecard)
                    <tr>
                        <td>{{ $onGoingTimecard->date }}</td>
                        <td>{{ explode(' ', $onGoingTimecard->start_time)[1] }}</td>
                        <td></td>
                        <td>{{ $onGoingTimecard->start_location }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $onGoingTimecard->comment }}</td>
                        <td>
                            <a href="{{ route('timecards.create') }}">
                            <button class="btn btn-outline-danger waves-effect px-2">
                                End your Workday
                            </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                @endif
                </tbody>

            </table>
        </div>

        @endif

        <div class="container rounded border border-secondary p-3 mt-3 bg-red">

            <h1 class="mb-3">Your Time Cards</h1>

            {{-- Filter form with POST method --}}
            {{-- Values are passed into index method of TimecardController --}}
            <form action="{{ route('timecards.filtered.worker') }}" method="POST" autocomplete="off">
            @csrf
                <div class="row rounded m-1 pt-2 align-items-center" style="background: #acd0ff;">
                    <div class="col-sm form-group">
                        <label for="fromDate"><strong>From Date:</strong></label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control"
                          value="">
                        @error('fromDate')
                          <span class="text-danger">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>

                      <div class="col-sm form-group">
                        <label for="toDate"><strong>To Date:</strong></label>
                        <input type="date" id="toDate" name="toDate" class="form-control"
                          value="">
                        @error('toDate')
                          <span class="text-danger">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>

                      <div class="col-sm">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-1"></i> Filter</button>
                      </div>
                </div>
            </form>

            <br>

            {{-- This is the condition to decide this filter is for Worker --}}
            {{-- Because on Worker side, they can only filter the Timecard by DATE
                 They dont have ability to filter by NAME --}}
            @if (\Request::is('timecards/filterByDate'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Filtering... </strong>

                <br> From:
                @if (@isset($fromDate))
                    {{ $fromDate }}
                @else
                    None
                @endif

                <br> To:
                @if (@isset($toDate))
                    {{ $toDate }}
                @else
                    None
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

                <table class="table table-hover mt-10 border table-bordered table-striped">

                {{-- Prints out the header of the table --}}
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Start Location</th>
                    <th scope="col">End Location</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Minutes</th>
                    <th scope="col">Comment</th>
                </tr>
                </thead>

                <tbody>
                @if ($allTimecards->isEmpty())
                <tr>
                <td colspan="9">
                    Nothing to display
                </td>
                </tr>

                @else

                    {{-- Loops through each Timecard passing by TimecardController class
                         Display them in each td --}}
                    @foreach ($allTimecards as $allTimecard)
                    <tr>
                        <th scope="row">{{ $eachIndex++ }}</th>
                        <td>{{ $allTimecard->date }}</td>
                        <td>{{ explode(' ', $allTimecard->start_time)[1] }}</td>
                        <td>{{ explode(' ', $allTimecard->end_time)[1] }}</td>
                        <td>{{ $allTimecard->start_location }}</td>
                        <td>{{ $allTimecard->end_location }}</td>
                        <td style="display: table-cell; text-align:center; vertical-align: middle">
                            <span class="badge badge-pill badge-light">{{ explode(':', $allTimecard->total_hours)[0] }}</span>
                        </td>
                        <td style="display: table-cell; text-align:center; vertical-align: middle;">
                            <span class="badge badge-pill badge-light">{{ explode(':', $allTimecard->total_hours)[1] }}</span>
                        </td><td>{{ $allTimecard->comment }}</td>
                    </tr>
                    @endforeach

                @endif
                </tbody>

            </table>
        </div>

    @endif
</div>


@endsection
