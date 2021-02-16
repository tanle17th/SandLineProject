<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
   public function index()
    {
        // Get data from databases
        // $workers = User::all();
        // $workers = User::orderBy('name', 'desc')->get();
        // $workers = User::where('type', 'hawaiian')->get();
        $workers = Incident::latest()->get();
       // $inidents = Incident::where('role', 'worker')->orderBy('name')->paginate(15);

        return view('workers.index', [
            'workers' => $workers
        ]);
    }

    public function edit($id)
    {
        // use $id to query the db
        $incident = Incident::findOrFail($id);

        return view('incidents.edit', [
            'incident' => $incident
        ]);
    }

    public function create()
    {
        return view('incidents.create');
    }

    // public function store()
    // {

    //     request()->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $user = new User();

    //     $user->name = request('name');
    //     $user->email = request('email');
    //     $user->password = Hash::make(request('password'));
    //     $user->role = 'worker';
    //     $user->is_active = request('is_active');

    //     $user->save();

    //     return redirect(route('workers.list'))->with('msg', 'New worker account added');
    // }

    // public function update($id)
    // {

    //     request()->validate([
    //         'name' => 'required',
    //         'email' => 'required'
    //     ]);

    //     $user = User::findOrFail(request('id'));

    //     $user->name = request('name');
    //     $user->email = request('email');
    //     if (request('password') != null) {
    //         $user->password = Hash::make(request('password'));
    //     }
    //     $user->role = 'worker';
    //     $user->is_active = request('is_active');

    //     $user->save();

    //     return redirect(route('workers.list'))->with('msg', 'Worker account updated');
    // }

    // public function delete($id)
    // {

    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect(route('workers.list'))->with('msg', 'Worker account deleted');
    // }
}
