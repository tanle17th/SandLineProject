
@extends('layouts.app')

@section('content')

@if (!is_null(session('mssg')) )
<div class="container-fluid mt-4">
<div class="container">
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <p> {{session('mssg')}}</p>
  </div> 
</div>
@endif

  <div class="container">

    <div class="table-title">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h2>Manage <b>Incidents</b></h2>
        </div>
        <div class="col-sm-6">
          <div class="float-right">
            <a href="{{ route('incidents.create') }}" class="btn btn-success justify-content-end">Add New Incident</a>
          </div>
        </div>
      </div>
    </div>

      <table class="table table-hover mt-4 border table-bordered">
      <thead class="indigo white-text">
        <tr>
          <th><b>Date</b></th>
          <th><b>Time</b></th>
          <th><b>Worker</b></th>
          <th><b>Location</b></th>
          <!-- <th><b>Details</b></th> -->
          <th><b>Image</b></th>
          <!-- <th><b>Additional Comment</b></th> -->
          <th><b>Status</b></th>
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
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->worker->name }}</td>
          <td style="display: table-cell; vertical-align: middle;">{{ $incident->location->fullLocation() }}</td>
          <!-- <td style="display: table-cell; vertical-align: middle;">{{ $incident->detail }}</td> -->
          <!-- <td style="display: table-cell; vertical-align: middle;"> {{ $incident->image == null? 'No Image': 'See Details'}}</td> -->
          <td> <img src={{ is_null($incident->image)? "/images/no-image.jpg" : "/images/$incident->image" }} style="max-width:120px;"/></td>
          <!-- <td><div><img src= "{{ asset('images')}}/{{$incident->image}}" style="max-width:120px;"/></div></td> -->
          <!-- <td style="display: table-cell; vertical-align: middle;">{{ $incident->comment }}</td> -->
          <td style="display: table-cell; vertical-align: middle;">
            <span style="height: 10px; width: 10px; margin-right: 4px;
                                  background-color:{{ $incident->is_active ? 'rgb(255, 0, 0)' : 'rgb(0, 122, 16)' }};
                                  border-radius: 50%; display: inline-block;"></span>
             {{ $incident->is_active ? 'Unresolved' : 'Resolved' }}
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
                  onclick="return confirm('Incident Date: {{ $incident->date}}\nIncident Time: {{ $incident->time}}\nReported By: {{ $incident->worker->name}}\n\nAre you sure you want to delete this incident?\n\nPress OK to Proceed with delete');">
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

    {{ $incidents->links() }}

  </div>
@endsection
