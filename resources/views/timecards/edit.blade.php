{{-- Edit one Timecard blade --}}
{{-- Only admin can reach this page --}}
{{-- Route(timecards.edit) --}}
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-sm-6">
          <h2>Edit <b>{{ $timecard->worker->name }}</b>'s Time Card</h2>
        </div>
    </div>

    <div class="row">

        <form class="col-sm-6" action="{{ route('timecards.edit', $timecard->id) }}" method="POST" autocomplete="off">
        @csrf

        <div class="form-group mt-4">
            <label for="start_date">Start Date: </label>
            <input type="date" id="start_date" name="start_date"
              value="{{ !is_null($timecard->start_time) ? (explode(' ', $timecard->start_time)[0]) : ''}}" class="form-control"
              required>
        @error('start_date')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-4">
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" placeholder="Select start time"
              value="{{ !is_null($timecard->start_time) ? (explode(' ', $timecard->start_time)[1]) : '' }}" required
              class="form-control">
        @error('start_time')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-4">
            <label for="end_date">End Date: </label>
            <input type="date" id="end_date" name="end_date"
              value="{{ !is_null($timecard->end_time) ? (explode(' ', $timecard->end_time)[0]) : ''}}" class="form-control"
              required>
        @error('end_date')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-4">
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" placeholder="Select end time"
              value="{{ !is_null($timecard->end_time) ? (explode(' ', $timecard->end_time)[1]) : '' }}"
              class="form-control">
        @error('end_time')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-2">
            <label for="start_location">Start Location:</label>
            <input type="text" class="form-control" disabled value="{{ $timecard->start_location }}">
        @error('start_location')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-2">
            <label for="end_location">End Location:</label>
            <input type="text" class="form-control" disabled value="{{ $timecard->end_location }}">
        @error('end_location')
            <span class="text-danger">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-group mt-4">
            <label for="comment">Additional comments:</label>
            <textarea class="form-control rounded-0" name="comment" rows="3"
              placeholder="">{{ $timecard->comment }}</textarea>
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
