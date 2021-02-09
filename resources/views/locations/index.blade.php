@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="table-title">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h2>Manage <b>Locations</b></h2>
        </div>
        <div class="col-sm-6">
          <div class="float-right">
            <a href="{{ route('locations.create') }}" class="btn btn-success justify-content-end">Add</a>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-hover mt-4 border table-bordered">
      <thead class="indigo white-text">
        <tr>
          <th><b>Address</b></th>
          <th><b>City</b></th>
          <th><b>Province</b></th>
          <th><b>Postal-code</b></th>
          <th><b>Country</b></th>
          <th class="text-center"><b>Action</b></th>
        </tr>
      </thead>

      @foreach ($locations as $location)
        <tr>
          <td style="display: table-cell; vertical-align: middle;">
            <span style="height: 10px; width: 10px; margin-right: 4px;
                                  background-color:{{ $location->is_active ? 'rgb(0, 122, 16)' : 'rgb(255, 0, 0)' }};
                                  border-radius: 50%; display: inline-block;"></span>
            {{ $location->address }}
          </td>
          <td style="display: table-cell; vertical-align: middle;">{{ $location->city }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $location->province }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $location->zipcode }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $location->country }}</td>
          <td class="text-right" style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
            <form action="{{ route('locations.delete', $location->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-default waves-effect px-3">
                  <a href="{{ route('locations.edit', $location->id) }}">
                    <i class="fas fa-edit"></i></a>
                </button>
                <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                  onclick="return confirm('{{ $location->fullLocation() }}\n\nAre you sure you want to delete this location?\nWARNING: It will also delete the worklogs related to this location.\nHint: The safe option is just to edit this location and make it inactive.\n\nPress OK to Proceed with delete');">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
      @endforeach

      @if ($locations->isEmpty())
        <tr>
          <td colspan="6">
            No locations to display
          </td>
        </tr>
      @endif

    </table>

    {{ $locations->links() }}

  </div>

@endsection
