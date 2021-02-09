@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">

        @if (is_null($previousWorklog))
          <h2>Punching <b>IN</b></h2>
        @else
          <h2>Punching <b>OUT</b></h2>
        @endif

      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="{{ route('worklogs.store') }}" method="POST" autocomplete="off">
        @csrf

        @if (is_null($previousWorklog))

          {{-- Punching In --}}

          <div class="form-group mt-4">
            <label for="worklogdate">Punch-in Date:</label>
            <input type="date" id="worklogdate" name="worklogdate" class="form-control" value="{{ date('Y-m-d') }}"
              required readonly>
            @error('worklogdate')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <label for="timer">Punch-in Time:</label>
            <input type="time" id="timer" name="timer" placeholder="Select time" class="form-control"
              value="{{ date('H:i') }}" required readonly>
            @error('timer')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <label for="sitelocation">Site location:</label>
            <select name="sitelocation" id="sitelocation" class="browser-default custom-select" required>
              <option disabled selected value="">Select a site location</option>
              @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->fullLocation() }}</option>
              @endforeach
            </select>
            @error('sitelocation')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <input type="submit" class="btn btn-success" value="Punch In">
          </div>

        @else

          {{-- Punching Out --}}

          <div class="form-group mt-4">
            <label>Punch-in Date:</label>
            <input type="date" class="form-control" disabled value="{{ explode(' ', $previousWorklog->starttime)[0] }}">
          </div>

          <div class="form-group mt-2">
            <label>Punch-in Time:</label>
            <input type="time" class="form-control" disabled value="{{ explode(' ', $previousWorklog->starttime)[1] }}">
          </div>

          <div class="form-group mt-2">
            <label>Location:</label>
            <input type="text" class="form-control" disabled value="{{ $previousWorklog->location->fullLocation() }}">
          </div>

          <div class="form-group mt-4">
            <label for="worklogdate">Punch-out Date:</label>
            <input type="date" id="worklogdate" name="worklogdate" class="form-control" value="{{ date('H:i') }}" required
              readonly>
            @error('worklogdate')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <label for="timer">Punch-out Time:</label>
            <input type="time" name="timer" id="timer" placeholder="Select time" class="form-control"
              value="{{ date('Y-m-d') }}" required readonly>
            @error('timer')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <label>Service(s) performed:</label>
            @foreach ($services as $service)
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="servicesperformed[]" id="{{ $service->id }}"
                  value="{{ $service->id }}" {{ $previousWorklog->checkServicePerformed($service) ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ $service->id }}">{{ $service->name }}</label>
              </div>
            @endforeach
            @error('servicesperformed')
              <span class="text-danger">
                <strong>You must have to select at least one sevice</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <label for="comment">Additional comments:</label>
            <textarea class="form-control rounded-0" name="comment" rows="3"
              placeholder="">{{ $previousWorklog->comment }}</textarea>
            @error('comment')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group mt-4">
            <input type="submit" class="btn btn-success" value="Punch Out">
          </div>

        @endif

      </form>

      <script>
        function refreshTime() {
          var today = new Date();
          document.getElementById('worklogdate').value =
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
