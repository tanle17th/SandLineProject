@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Create <b>New</b> Incident</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="/incidents/store" method="POST" autocomplete="off">
        @csrf
        <div class="form-group mt-4">
          <label>Date</label>
          <input type="date" name="date" class="form-control" placeholder="Date" autocomplete="false" autocomplete='off'
            required>
          @error('date')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="time" name="time" class="form-control" placeholder="Time" required autocomplete="false"
            autocomplete='off' required>
          @error('time')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <!-- <div class="form-group">
          <label>Detail</label>
          <input type="text" name="detail" class="form-control" placeholder="Detail" required autocomplete="false"
            autocomplete='off' required>
          @error('password')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> -->

        <div class="form-group mt-4">
            <label for="detail">Detail:</label>
            <textarea class="form-control rounded-0" name="detail" rows="3"
              placeholder="">Enter Detail</textarea>
            @error('detail')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

        <div class="form-group">
          <label>Image</label>
          <input type="text" name="image" class="form-control" placeholder="Image" required autocomplete="false"
            autocomplete='off' required>
          @error('image')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <!-- <div class="form-group">
          <label>Comment</label>
          <input type="text" name="comment" class="form-control" placeholder="Comment" required autocomplete="false"
            autocomplete='off' required>
          @error('time')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> -->


         <div class="form-group mt-4">
            <label for="comment">Comment:</label>
            <textarea class="form-control rounded-0" name="comment" rows="3"
              placeholder="">Enter Comment</textarea>
            @error('comment')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

        <!-- <div class="form-group mt-4">
          <label>Status</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="active" name="is_active" value="1" checked>
            <label class="form-check-label" for="active">
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="inactive" name="is_active" value="0">
            <label class="form-check-label" for="inactive">
              Inactive
            </label>
          </div>
        </div> -->

        <div class="form-group mt-4">
          <input type="submit" class="btn btn-success" value="Create">
        </div>
      </form>

    </div>
  </div>

@endsection
