@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    {{-- This php block here implements the function to decide whether
        the words displayed in 1/ Create Property Log
                               2/ Create Time Card
        are Start or End--}}
    {{-- They are basically the same set of idea --}}
    {{-- Get the latest property log and/or timecard
         where the end time is null (meaning worker has not ended, just started)
         + If it is empty, meaning worker is starting/creating new
         + If it is not empty, meaning worker is ending that time card --}}
    @php
    $start_or_end_propertylog = DB::table('worklogs')->where([
        ['user_id', Auth::user()->id],
        ['endtime', null]
    ])->first();

    if (empty($start_or_end_propertylog)) {
        $displayPropertyLog = array(
            'header' => 'New Property log',
            'headerImageURL' => 'https://images.unsplash.com/photo-1477577314779-8dd53d8e615f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1055&q=80',
            'message' => 'Begin New Property Log.',
            'buttonText' => 'Begin',
            'buttonLink' => route('worklogs.create'),
            );
    } else {
        $displayPropertyLog = array(
            'header' => 'Ongoing Property log',
            'headerImageURL' => 'https://images.unsplash.com/photo-1477577314779-8dd53d8e615f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1055&q=80',
            'message' => 'On-Going Property Log.',
            'buttonText' => 'Complete',
            'buttonLink' => route('worklogs.create'),
            );
    }


    $start_or_end_timecard = DB::table('timecards')->where([
            ['user_id', Auth::user()->id],
            ['end_time', null]
        ])->first();

    if (empty($start_or_end_timecard)) {
        $displayTimeCard = array(
            'header' => 'New Time Card',
            'headerImageURL' => 'https://media.istockphoto.com/photos/records-work-hours-in-a-time-sheet-picture-id804619472?k=6&m=804619472&s=612x612&w=0&h=OaPvcO423phurj69OEWVzitPG_vqVJtfCkVasGFSf4w=',
            'message' => 'Start your Workday.
            ',
            'buttonText' => 'Start',
            'buttonLink' => route('timecards.create'),
            );
    } else {
        $displayTimeCard = array(
            'header' => 'On-Going Time Card',
            'headerImageURL' => 'https://media.istockphoto.com/photos/records-work-hours-in-a-time-sheet-picture-id804619472?k=6&m=804619472&s=612x612&w=0&h=OaPvcO423phurj69OEWVzitPG_vqVJtfCkVasGFSf4w=',
            'message' => 'End your Workday.
            ',
            'buttonText' => 'End',
            'buttonLink' => route('timecards.create'),
            );
    }

    $cards = [
    $displayPropertyLog,
    array(
    'header' => 'Completed Property Logs',
    'headerImageURL' => 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80',
    'message' => 'View Daily Property Logs.',
    'buttonText' => 'Completed Property Logs',
    'buttonLink' => route('worklogs.list'),
    ),
    $displayTimeCard,
    array(
    'header' => 'Completed Time Cards',
    'headerImageURL' => 'https://cfw.paymoapp.com/wp-content/uploads/2019/10/What-is-a-timesheet-featured-image.png',
    'message' => 'Manage your Time Cards.
    ',
    'buttonText' => 'Go to Time Cards List',
    'buttonLink' => route('timecards.list'),
    ),
    array(
    'header' => 'Incident Report',
    'headerImageURL' => 'https://images.template.net/wp-content/uploads/2017/05/Incident-Report-Template.jpg',
    'message' => 'Report any incident that happens.',
    'buttonText' => 'Make new incident',
    'buttonLink' => route('incidents.create'),
    ),
    ];
    @endphp

    <div class="row justify-content-center">

        @foreach ($cards as $card)

        <div class="col-auto mb-4">
            <!-- Card -->
            <div class="card" style="width: 18rem;">

                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="{{ $card['headerImageURL'] }}" alt="Card image cap" height="200px">
                    <!-- <a href="#!">
					<div class="mask rgba-white-slight"></div>
				</a> -->
                </div>

                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title">{{ $card['header'] }}</h4>
                    <!--Text-->
                    <p class="card-text">{{ $card['message'] }}</p>
                    <a type="button" class="card-link" href="{{ $card['buttonLink'] }}">{{ $card['buttonText'] }}</a>

                </div>

            </div>
            <!-- Card -->
        </div>

        @endforeach

    </div>
</div>

@endsection
