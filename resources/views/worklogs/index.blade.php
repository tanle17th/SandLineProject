@extends('layouts.app')

@section('content')

  <div class="container">

    @if (isset($worker))
      <h2 class="mb-3"><b>Showing logs of user: </b>{{ $worker->name }}</h2>
    @endif

    @if (isset($onGoingWorklogs))

      <div class="container rounded border border-warning p-3 bg-white">

        <h3><b>Ongoing</b> Worklogs</h3>

        <table class="table table-hover mt-3 border table-bordered">
          <thead class="indigo white-text">
            <tr>
              <th><b>Date</b></th>
              <th><b>Start time</b></th>
              @if ($is_admin)
                <th><b>Worker</b></th>
              @endif
              <th><b>Location</b></th>
              <th class="text-center"><b>Action</b></th>
            </tr>
          </thead>

          @foreach ($onGoingWorklogs as $worklog)
            <tr>
              <td style="display: table-cell; vertical-align: middle;">
                {{ explode(' ', $worklog->starttime)[0] }}
              </td>
              <td style="display: table-cell; vertical-align: middle;">
                {{ explode(' ', $worklog->starttime)[1] }}
              </td>
              @if ($is_admin)
                <td style="display: table-cell; vertical-align: middle;">
                  <a
                    href="{{ route('worklogs.list.filtered.by.worker', ['worker_id' => $worklog->worker->id]) }}">{{ $worklog->worker->name }}</a>
                </td>
              @endif
              <td style="display: table-cell; vertical-align: middle;">
                {{ $worklog->location->fullLocation() }}
              </td>
              @if ($is_admin)
                <td class="text-right"
                  style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
                  <form action="{{ route('worklogs.delete', $worklog->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-outline-default waves-effect px-3">
                        <a href="{{ route('worklogs.edit', $worklog->id) }}">
                          <i class="fas fa-edit"></i></a>
                      </button>
                      <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                        onclick="return confirm('Are you sure you want to this worklog?');">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </form>
                </td>
              @else
                <td style="display: table-cell; vertical-align: middle; width:17%; white-space: nowrap;">
                  <button type="button" class="btn btn-success ">
                    <a href="{{ route('worklogs.create') }}">Punch-Out</a></button>
                </td>
              @endif
            </tr>
          @endforeach

          @if ($onGoingWorklogs->isEmpty())
            <tr>
              <td colspan="5">
                No ongoing worklogs to display
              </td>
            </tr>
          @endif

        </table>
      </div>

    @endif

    <div class="container rounded border border-primary p-3 mt-3 bg-white">


      <div class="row justify-content-between">
        <div class="col-4">
          <h3>Past Worklogs</h3>
        </div>
        <div class="col-4" style="text-align:end">
          <a href="{{ route('worklogs.list.export') }}">
            <i class="fas fa-file-excel mr-2"></i> Export All Worklogs to Excel
          </a>
        </div>
      </div>




      @if (Route::currentRouteName() == 'worklogs.list')

      @endif

      @if (!isset($worker))

        <form action="{{ route('worklogs.list.filtered.by.date') }}" method="GET" autocomplete="off">

          <div class="row rounded m-1 pt-2 align-items-center" style="background: #acdaff;">

            <div class="col-sm form-group">
              <label for="fromdate">From Date:</label>
              <input type="date" id="fromdate" name="fromdate" class="form-control"
                value="{{ isset($_GET['fromdate']) ? $_GET['fromdate'] : '' }}" required>
              @error('fromdate')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="col-sm form-group">
              <label for="todate">To Date:</label>
              <input type="date" id="todate" name="todate" class="form-control"
                value="{{ isset($_GET['todate']) ? $_GET['todate'] : '' }}" required>
              @error('todate')
                <span class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="col-sm">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-2"></i> Filter</button>
            </div>

          </div>

        </form>
      @endif

      <table class="table table-hover mt-3 border table-bordered">
        <thead class="indigo white-text">
          <tr>
            <th><b>Date</b></th>
            <th><b>Start time</b></th>
            <th><b>End time</b></th>
            @if ($is_admin)
              <th><b>Worker</b></th>
            @endif
            <th><b>Location</b></th>
            <th><b>Services</b></th>
            <th><b>Comments</b></th>
            @if ($is_admin)
              <th class="text-center"><b>Action</b></th>
            @endif
          </tr>
        </thead>

        @foreach ($worklogs as $worklog)
          @php
          $startDate = explode(' ', $worklog->starttime)[0];
          $startTime = explode(' ', $worklog->starttime)[1];
          $endDate = explode(' ', $worklog->endtime)[0];
          $endTime = explode(' ', $worklog->endtime)[1];
          @endphp
          <tr>
            <td style="white-space: nowrap; display: table-cell; vertical-align: middle;">
              {{ $startDate }}
            </td>
            <td style="white-space: nowrap; display: table-cell; vertical-align: middle;">
              {{ $startTime }}
            </td>
            <td style="display: table-cell; vertical-align: middle;">
              {{ $startDate == $endDate ? $endTime : $endDate . ' ' . $endTime }}
            </td>
            @if ($is_admin)
              <td style="display: table-cell; vertical-align: middle;">
                <a
                  href="{{ route('worklogs.list.filtered.by.worker', ['worker_id' => $worklog->worker->id]) }}">{{ $worklog->worker->name }}</a>
              </td>
            @endif
            <td style="display: table-cell; vertical-align: middle;">
              {{ $worklog->location->fullLocation() }}
            </td>
            <td style="display: table-cell; vertical-align: middle;">
              @foreach ($worklog->services as $service)
                <span class="badge badge-pill badge-secondary">{{ $service->name }}</span>
              @endforeach
            </td>
            <td style="display: table-cell; vertical-align: middle;">{{ $worklog->comment }}</td>
            @if ($is_admin)
              <td class="text-right"
                style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
                <form action="{{ route('worklogs.delete', $worklog->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-default waves-effect px-3">
                      <a href="{{ route('worklogs.edit', $worklog->id) }}">
                        <i class="fas fa-edit"></i></a>
                    </button>
                    <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                      onclick="return confirm('Are you sure you want to this worklog?');">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </form>
              </td>
            @endif
          </tr>
        @endforeach

        @if ($worklogs->isEmpty())
          <tr>
            <td colspan="8">
              No worklogs to display
            </td>
          </tr>
        @endif

      </table>

      {{ $worklogs->links() }}

    </div>

  </div>

@endsection
