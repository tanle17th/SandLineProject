@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Edit <b>existing</b> incident details</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="/incidents/{{$incident->id}}" method="POST" autocomplete="off">
        @csrf

        <div class="form-group mt-4">
          <label>Date</label>
          <input type="date" name="date" class="form-control" placeholder="Date" autocomplete="false"
            autocomplete='off' value="{{ $incident->date }}" required>
          @error('date')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Time</label>
          <input type="time" name="time" class="form-control" placeholder="Time" autocomplete="false" autocomplete='off'
            value="{{ $incident->time }}" required>
          @error('time')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <!-- <div class="form-group mt-4">
          <label>Location</label>
          <input type="text" name="location" class="form-control" placeholder="Location" autocomplete="false"
            autocomplete='off' value="{{ $incident->location }}" required>
          @error('location')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> -->

        <div class="form-group mt-4">
            <label for="detail">Detail:</label>
            <textarea class="form-control rounded-0" name="detail" rows="3"
              placeholder="">{{ $incident->detail }}</textarea>
            @error('detail')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

        <div class="form-group mt-4">
          <label>Image</label>
          <input type="text" name="image" class="form-control" placeholder="Image" autocomplete="false"
            autocomplete='off' value="{{ $incident->image }}" required>
          @error('image')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
            <label for="comment">Comment:</label>
            <textarea class="form-control rounded-0" name="comment" rows="3"
              placeholder="">{{ $incident->comment }}</textarea>
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
