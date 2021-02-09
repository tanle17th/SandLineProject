@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="table-title">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h2>Manage <b>Services</b></h2>
        </div>
        <div class="col-sm-6">
          <div class="float-right">
            <a href="{{ route('services.create') }}" class="btn btn-success justify-content-end">Add</a>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-hover mt-4 border table-bordered">
      <thead class="indigo white-text">
        <tr>
          <th><b>Name</b></th>
          <th class="text-center"><b>Action</b></th>
        </tr>
      </thead>

      @foreach ($services as $service)
        <tr>
          <td style="display: table-cell; vertical-align: middle;">
            <span style="height: 10px; width: 10px; margin-right: 4px;
                                background-color:{{ $service->is_active ? 'rgb(0, 122, 16)' : 'rgb(255, 0, 0)' }};
                                border-radius: 50%; display: inline-block;"></span>
            {{ $service->name }}
          </td>
          <td class="text-right" style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
            <form action="{{ route('services.delete', $service->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-default waves-effect px-3">
                  <a href="{{ route('services.edit', $service->id) }}">
                    <i class="fas fa-edit"></i></a>
                </button>
                <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                  onclick="return confirm('{{ $service->name }}\n\nAre you sure you want to delete this service?\nWARNING: This will remove this service from Worklogs as well if you have any past worklogs with this service.\nHint: Prefer updating this service and making it inactive rather.\n\nPress OK if you want to proceed with delete.');">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
      @endforeach

      @if ($services->isEmpty())
        <tr>
          <td colspan="2">
            No services to display
          </td>
        </tr>
      @endif

    </table>

    {{ $services->links() }}

  </div>

@endsection
