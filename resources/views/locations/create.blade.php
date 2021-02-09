@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Add a <b>new</b> location</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="{{ route('locations.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="form-group mt-4">
          <label>Address</label>
          <input type="text" name="address" class="form-control" placeholder="Address" autocomplete="false"
            autocomplete='off' required>
          @error('address')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>City</label>
          <input type="text" name="city" class="form-control" placeholder="City" autocomplete="false" autocomplete='off'
            required>
          @error('city')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Province</label>
          <input type="text" name="province" class="form-control" placeholder="Province" autocomplete="false"
            autocomplete='off' required>
          @error('province')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Postal-Code</label>
          <input type="text" name="zipcode" class="form-control" placeholder="Postal-Code" autocomplete="false"
            autocomplete='off' required>
          @error('zipcode')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Country</label>
          <input type="text" name="country" class="form-control" placeholder="Country" autocomplete="false"
            autocomplete='off' required>
          @error('country')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Status</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="active" name="is_active" value="1">
            <label class="form-check-label" for="active" checked>
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="inactive" name="is_active" value="0">
            <label class="form-check-label" for="inactive">
              Inactive
            </label>
          </div>
        </div>

        <div class="form-group mt-4">
          <input type="submit" class="btn btn-success" value="Add Location">
        </div>
      </form>

    </div>
  </div>

@endsection
