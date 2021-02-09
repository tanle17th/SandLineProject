@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    @php
        $cards = [
            array(
                'header' => 'Add Work log',
                'headerImageURL' => 'https://images.unsplash.com/photo-1477577314779-8dd53d8e615f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1055&q=80',
                'message' => 'Add a new work log.',
                'buttonText' => 'Add Work log',
                'buttonLink' => route('worklogs.create'),
            ),
            array(
                'header' => 'My Work logs',
                'headerImageURL' => 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80',
                'message' => 'Retrieve the daily work log forms.',
                'buttonText' => 'Open Work logs',
                'buttonLink' => route('worklogs.list'),
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
