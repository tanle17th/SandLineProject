@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-sm-6">
            @if (is_null($startOfWorkday))
            <h1><b>Start of Work Day</b></h1>
            @else
            <h1><b>End of Work Day</b></h1>
            @endif
        </div>
    </div>


    <div class="row">

    <form class="col-sm-6" action="{{ route('timecards.store') }}" method="POST">
    @csrf

        @if (is_null($startOfWorkday))

            <div class="form-group mt-4">
                <label for="timecarddate">Date start: </label>
                <input type="date" id="timecarddate" name="timecarddate" class="form-control"
                value="{{ date('Y-m-d') }}" required readonly>
            </div>

            <div class="form-group mt-4">
                <label for="timer">Time start: </label>
                <input type="time" id="timer" name="timer" class="form-control"
                value="{{ date('H:i') }}" required readonly>
            </div>

            <div class="form-group mt-4">
                <label for="start_location">Location start: </label>
                <input type="text" class="form-control" disabled value="{{ 'Auto Specified' }}" name="start_location">
            </div>

            <div class="form-group mt-4">
                <label for="start_comment">Comment:</label>
                <textarea class="form-control rounded-0" name="start_comment" rows="2"
                placeholder=""></textarea>
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-success" value="Start your Workday!">
            </div>

        @else

            <div class="form-group mt-4">
                <label>Date start:</label>
                <input type="date" class="form-control" disabled value="{{ $startOfWorkday->date }}">
            </div>

            <div class="form-group mt-2">
                <label>Time start:</label>
                <input type="time" class="form-control" disabled value="{{ explode(' ', $startOfWorkday->start_time)[1] }}">
            </div>

            <div class="form-group mt-2">
                <label>Location start:</label>
                <input type="text" class="form-control" disabled value="{{ $startOfWorkday->start_location->fullLocation() }}">
            </div>

            <div class="form-group mt-4">
                <label for="timecarddate">Date end:</label>
                <input type="date" id="timecarddate" name="timecarddate" class="form-control" value="{{ date('Y-m-d') }}" required
                readonly>
                @error('timecarddate')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="timer">Time end:</label>
                <input type="time" name="timer" id="timer" placeholder="Select time" class="form-control"
                value="{{ date('H:i') }}" required readonly>
                @error('timer')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="end_location">Location end:</label>
                <input type="text" class="form-control" disabled value="{{ 'Auto Specified' }}" name="end_location">
            </div>

            <div class="form-group mt-4">
                <label for="end_comment">Comment:</label>
                <textarea class="form-control rounded-0" name="end_comment" rows="2"
                placeholder="">{{ $startOfWorkday->comment }}</textarea>
                @error('end_comment')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group mt-4">
                <input type="submit" class="btn btn-danger" value="End your Workday!">
            </div>

        @endif
    </form>

    <script>
        function refreshTime() {
          var today = new Date();
          document.getElementById('timecarddate').value =
            today.getFullYear() + '-' + ((today.getMonth() + 1) < 10 ? '0' : '') + (today.getMonth() + 1) + '-' + (today
              .getDate() < 10 ? '0' : '') + today.getDate();
          document.getElementById('timer').value =
            (today.getHours() < 10 ? '0' : '') + today.getHours() + ':' + (today.getMinutes() < 10 ? '0' : '') + today
            .getMinutes();
          setTimeout(refreshTime, 1000);
        }
        refreshTime();
      </script>
</div>
</div>


@endsection
