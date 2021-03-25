@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Create <b>New</b> Incident</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="/incidents/store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-4">
          <label>Date:</label>
          <input type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
            required readonly>
          @error('date')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label>Time:</label>
         <input type="time" id="time" name="time" placeholder="Select time" class="form-control"
          value="{{ date('H:i') }}" required readonly>
          @error('timer')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
            <label for="location">Location:</label>
            <select name="location" id="location" class="browser-default custom-select" required>
              <option disabled selected value="">Select a location</option>
              @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->fullLocation() }}</option>
              @endforeach
            </select>
            @error('location')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>

        <div class="form-group mt-4">
            <label for="detail">Details:</label>
            <textarea class="form-control rounded-0" name="detail" rows="3"
              placeholder="">Enter Detail</textarea>
            @error('detail')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>

        <div class="form-group mt-4">
          <label for file>Upload Image:</label>
          <input type="file" name="file" class="form-control" />
          @error('file')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

         <div class="form-group mt-4">
            <label for="comment">Additional Comment:</label>
            <textarea class="form-control rounded-0" name="comment" rows="3"
              placeholder="">Enter Comment</textarea>
            @error('comment')
              <span class="text-danger">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

        <div class="form-group mt-4">
          <input type="submit" class="btn btn-green" value="Create">
        </div>
      </form>

    </div>
  </div>

<script>
  function refreshTime() {
    var today = new Date();
    document.getElementById('date').value =
        today.getFullYear() + '-' + ((today.getMonth() + 1) < 10 ? '0' : '') + (today.getMonth() + 1) + '-' + (today
        .getDate() < 10 ? '0' : '') + today.getDate();
    document.getElementById('time').value =
        (today.getHours() < 10 ? '0' : '') + today.getHours() + ':' + (today.getMinutes() < 10 ? '0' : '') + today
        .getMinutes();
    setTimeout(refreshTime, 1000);
    }
    refreshTime();
</script>

@endsection
