@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Update <b>existing</b> incident details</h2>
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

        <div class="form-group mt-4">
          <label for="location">Location</label>
          <select name="location" id="location" class="browser-default custom-select" required>
            <option disabled selected value="">Select a site location</option>
            @foreach ($locations as $location)
              {{ $selected = $location->id == $incident->location->id ? 'selected' : '' }}
              <option value="{{ $location->id }}" {{ $selected }}>{{ $location->fullLocation() }}</option>
            @endforeach
          </select>
          @error('location')
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

        <!-- <div class="form-group mt-4">
          <label>Image</label>
          <input type="text" name="image" class="form-control" placeholder="Image" autocomplete="false"
            autocomplete='off' value="{{ $incident->image }}" required>
          @error('image')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> -->

        <!-- <div class="form-group mt-4">
          <label for file>Upload Image:</label>
          <input type="file" name="file" class="form-control" src="{{ asset('images')}}/{{$incident->image}}" style="max-width:120px;" onchange="previewFile(this)" />
          <img id="previewImage" alt="Incident Image" style="max-width:130px;margin-top:20px;" />
          @error('file')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> -->

        <div class="form-group mt-4">
          <label for file>Upload Image:</label>
          <input type="file" name="file" class="form-control" onchange="previewFile(this)" />
          <img id="previewImage" alt="Incident Image" src="{{ asset('images')}}/{{$incident->image}}" style="max-width:130px;margin-top:20px;" />
          @error('file')
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
          <label>Status</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="active" name="is_active" value="1"
              {{ $incident->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="active">
              Unresolved
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="inactive" name="is_active" value="0"
              {{ $incident->is_active ? '' : 'checked' }}>
            <label class="form-check-label" for="inactive">
              Resolved
            </label>
          </div>
        </div>

    

        <div class="form-group mt-4">
          <input type="submit" class="btn btn-success" value="Update">
        </div>
      </form>

    </div>
  </div>

@endsection

<script>
    function previewFile(input){
      var file=$("input[type=file]").get(0).files[0];
      if(file) 
      {
        var reader = new FileReader();
        reader.onload = function(){
          $('#previewImage').altr("src",reader.result);
        }
        reader.readAsDataURL(file);
      }
    }
</script>