@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="table-title">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h2>Manage <b>Workers</b></h2>
        </div>
        <div class="col-sm-6">
          <div class="float-right">
            <a href="{{ route('workers.create') }}" class="btn btn-success justify-content-end">Add</a>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-hover mt-4 border table-bordered">
      <thead class="indigo white-text">
        <tr>
          <th><b>Name</b></th>
          <th><b>Email</b></th>
          <th class="text-center"><b>Action</b></th>
        </tr>
      </thead>

      @foreach ($workers as $worker)
        <tr>
          <td style="display: table-cell; vertical-align: middle;">
            <span style="height: 10px; width: 10px; margin-right: 4px;
                                    background-color:{{ $worker->is_active ? 'rgb(0, 122, 16)' : 'rgb(255, 0, 0)' }};
                                    border-radius: 50%; display: inline-block;"></span>
            <a
              href="{{ route('worklogs.list.filtered.by.worker', ['worker_id' => $worker->id]) }}">{{ $worker->name }}</a>
          </td>
          <td style="display: table-cell; vertical-align: middle;">{{ $worker->email }}</td>
          <td class="text-right" style="display: table-cell; vertical-align: middle; width:0.1%; white-space: nowrap;">
            <form action="{{ route('workers.delete', $worker->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-default waves-effect px-3">
                  <a href="{{ route('workers.edit', $worker->id) }}">
                    <i class="fas fa-edit"></i></a>
                </button>
                <button type="submit" class="btn btn-outline-danger waves-effect px-3"
                  onclick="return confirm('Deleting: {{ $worker->name }}\n\nAre you sure you want to delete this worker account?\nWARNING: It will also delete the worklogs related to this user.\n\nHint: The safe option is just to edit this worker account and make it inactive.\n\nPress OK to Proceed with delete');">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
      @endforeach

      @if ($workers->isEmpty())
        <tr>
          <td colspan="3">
            No worker accounts to display
          </td>
        </tr>
      @endif

    </table>

    {{ $workers->links() }}

  </div>

@endsection
