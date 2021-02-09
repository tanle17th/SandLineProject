@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Edit <b>existing</b> worklog</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="{{ route('worklogs.edit', $worklog->id) }}" method="POST" autocomplete="off">
        @csrf

        <div class="form-group mt-4">
          <label for="worklogdate">Punch-in Date:</label>
          <input type="date" id="worklogdatestart" name="worklogdatestart"
            value="{{ !is_null($worklog->starttime) ? explode(' ', $worklog->starttime)[0] : '' }}" class="form-control"
            required>
          @error('worklogdatestart')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label for="starttime">Punch-in Time:</label>
          <input type="time" name="starttime" placeholder="Select time"
            value="{{ !is_null($worklog->starttime) ? explode(' ', $worklog->starttime)[1] : '' }}" required
            class="form-control">
          @error('starttime')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label for="worklogdate">Punch-out Date:</label>
          <input type="date" id="worklogdateend" name="worklogdateend"
            value="{{ !is_null($worklog->endtime) ? explode(' ', $worklog->endtime)[0] : '' }}" class="form-control">
          @error('worklogdateend')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label for="endtime">Punch-out Time:</label>
          <input type="time" name="endtime" placeholder="Select time"
            value="{{ !is_null($worklog->endtime) ? explode(' ', $worklog->endtime)[1] : '' }}" class="form-control">
          @error('endtime')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label for="sitelocation">Site location</label>
          <select name="sitelocation" id="sitelocation" class="browser-default custom-select" required>
            <option disabled selected value="">Select a site location</option>
            @foreach ($locations as $location)
              {{ $selected = $location->id == $worklog->location->id ? 'selected' : '' }}
              <option value="{{ $location->id }}" {{ $selected }}>{{ $location->fullLocation() }}</option>
            @endforeach
          </select>
          @error('sitelocation')
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
                value="{{ $service->id }}" {{ $worklog->checkServicePerformed($service) ? 'checked' : '' }}>
              <label class="custom-control-label" for="{{ $service->id }}">{{ $service->name }}</label>
            </div>
          @endforeach
          @error('servicesperformed')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label for="comment">Additional comments:</label>
          <textarea class="form-control rounded-0" name="comment" rows="3"
            placeholder="">{{ $worklog->comment }}</textarea>
          @error('comment')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <input type="submit" class="btn btn-success" value="Update">
        </div>
      </form>

    </div>
  </div>

@endsection
