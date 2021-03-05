
@extends('layouts.app')

@section('content')
  <div> <p> {{session('mssg')}}</p> </div>
  <div class="container">

    <div class="table-title">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h2>Manage <b>Incidents</b></h2>
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div>

      <table class="table table-hover mt-4 border table-bordered">
      <thead class="indigo white-text">
        <tr>
          <th><b>Date</b></th>
          <th><b>Time</b></th>
          <th><b>Detail</b></th>
          <th><b>Image</b></th>
          <th><b>Comment</b></th>
          <th class="text-center"><b>Action</b></th>
        </tr>
      </thead>

      @foreach ($incidents as $incident)
        <tr>
          <td style="display: table-cell; vertical-align: middle;">
            <span style="height: 10px; width: 10px; margin-right: 4px;
                                  background-color: rgb(255, 0, 0)';
                                  border-radius: 50%; display: inline-block;"></span>
            {{ $incident->date }}
          </td>
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->time }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->detail }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->image }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->comment }}</td>
          <td class="text-right" style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
            <form action="/incidents/{{$incident->id}}" method="POST">
              @csrf
              @method('DELETE')
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-default waves-effect px-3">
                  <a href="{{ route('incidents.edit', $incident->id) }}">
                    <i class="fas fa-edit"></i></a>
                </button>
                <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                  onclick="return confirm('{{ $incident->date}}\n\nAre you sure you want to delete this incident?\nWARNING: It will also delete the worklogs related to this location.\nHint: The safe option is just to edit this location and make it inactive.\n\nPress OK to Proceed with delete');">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
      @endforeach

      @if ($incidents->isEmpty())
        <tr>
          <td colspan="6">
            No Incident to display
          </td>
        </tr>
      @endif

    </table>

  </div>
@endsection
