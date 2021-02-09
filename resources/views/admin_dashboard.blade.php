@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    @php
        $cards = [
            array(
                'header' => 'Work logs',
                'headerImageURL' => 'https://images.unsplash.com/photo-1453928582365-b6ad33cbcf64?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1052&q=80',
                'message' => 'Retrieve the daily work log forms.',
                'buttonText' => 'Open Work logs',
                'buttonLink' => route('worklogs.list'),
            ),
            array(
                'header' => 'Services',
                'headerImageURL' => 'https://images.unsplash.com/photo-1529220502050-f15e570c634e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=801&q=80',
                'message' => 'Add/modify services.',
                'buttonText' => 'Open Services',
                'buttonLink' => route('services.list'),
            ),
            array(
                'header' => 'Site locations',
                'headerImageURL' => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1033&q=80',
                'message' => 'Add/modify site locations.',
                'buttonText' => 'Open Site locations',
                'buttonLink' => route('locations.list'),
            ),
            array(
                'header' => 'Workers',
                'headerImageURL' => 'https://images.unsplash.com/photo-1563823251941-b9989d1e8d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80',
                'message' => 'Add/modify workers.',
                'buttonText' => 'Manage Workers',
                'buttonLink' => route('workers.list'),
            )
        ];
    @endphp

    <div class="row justify-content-center">

        @foreach ($cards as $card)

        <div class="col-auto mb-4">
            <!-- Card -->
            <div class="card" style="width: 18rem;">

                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top"
                        src="{{ $card['headerImageURL'] }}"
                        alt="Card image cap" height="200px">
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
