@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-sm-6">
        <h2>Edit <b>existing</b> worker account details</h2>
      </div>
    </div>

    <div class="row">

      <form class="col-sm-6" action="{{ route('workers.edit', $worker->id) }}" method="POST" autocomplete="off">
        @csrf
        <div class="form-group mt-4">
          <label>Name</label>
          <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="false" autocomplete='off'
            value="{{ $worker->name }}" required>
          @error('name')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="false"
            autocomplete='off' value="{{ $worker->email }}" required>
          @error('email')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group">
          <label>Password (leave this empty to keep previous password)</label>
          <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="false"
            autocomplete='off'>
          @error('password')
            <span class="text-danger">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-4">
          <label>Status</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="active" name="is_active" value="1"
              {{ $worker->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="active">
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="inactive" name="is_active" value="0"
              {{ $worker->is_active ? '' : 'checked' }}>
            <label class="form-check-label" for="inactive">
              Inactive
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
