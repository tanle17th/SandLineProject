{{-- Create one new Timecard blade --}}
{{-- Every users can reach this page --}}
{{-- Route(timecards.create) --}}
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


    <div class="row justify-content-between">

        {{-- After filling out the form, the form will be POST into
             route(timecards.store) to store to the database --}}
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

            <div>
                <div class="form-group mt-4">
                    <label for="start_location">Location start: </label>
                    <input id="start_location" type="text" class="form-control" name="start_location" required readonly>
                </div>

                <div id="floating-panel">
                    <input id="submit" type="button" value="Get current location" />
                </div>

                @error('start_location')
                <span class="text-danger">
                  <strong>You must specify your current location</strong>
                </span>
                @enderror

            </div>

            <div class="form-group mt-4">
                <label for="start_comment">Comment:</label>
                <textarea class="form-control rounded-0" name="start_comment" rows="3"
                placeholder=""></textarea>
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-outline-success" value="Start your Workday!">
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
                <input type="text" class="form-control" disabled value="{{ $startOfWorkday->start_location }}">
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

            <div>
                <div class="form-group mt-4">
                    <label for="end_location">Location end:</label>
                    <input id="end_location" type="text" class="form-control" name="end_location" required readonly>
                </div>

                <div id="floating-panel">
                    <input id="submit" type="button" value="Get current location" />
                </div>

                @error('end_location')
                <span class="text-danger">
                    <strong>You must specify your current location</strong>
                  </span>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="end_comment">Comment:</label>
                <textarea class="form-control rounded-0" name="end_comment" rows="3"
                placeholder="">{{ $startOfWorkday->comment }}</textarea>
                @error('end_comment')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-outline-danger" value="End your Workday!">
            </div>

        @endif
    </form>

    {{-- This is where the Map is displayed on the page --}}
    {{-- It is used in geolocation.js file --}}
    <div class="col-5" id="map"></div>

</div>

</div>

@endsection

{{-- Using direct script inside blade with VUS framework is not recommended and could cause
     unexpected error --}}
{{-- Alternatively, declare those scripts externally (in external js files)
     Paste those files in parent blade
     And push them into each child blade --}}
@push('scripts')
<script src="{{ asset('js/refresh-time.js') }}"></script>
<script src="{{ asset('js/geolocation.js') }}"></script>
@endpush
