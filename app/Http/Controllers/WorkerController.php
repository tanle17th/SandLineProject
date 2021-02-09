<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WorkerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get data from databases
        // $workers = User::all();
        // $workers = User::orderBy('name', 'desc')->get();
        // $workers = User::where('type', 'hawaiian')->get();
        // $workers = User::latest()->get();
        $workers = User::where('role', 'worker')->orderBy('name')->paginate(15);

        return view('workers.index', [
            'workers' => $workers
        ]);
    }

    public function edit($id)
    {
        // use $id to query the db
        $worker = User::findOrFail($id);

        return view('workers.edit', [
            'worker' => $worker
        ]);
    }

    public function create()
    {
        return view('workers.create');
    }

    public function store()
    {

        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();

        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->role = 'worker';
        $user->is_active = request('is_active');

        $user->save();

        return redirect(route('workers.list'))->with('msg', 'New worker account added');
    }

    public function update($id)
    {

        request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user = User::findOrFail(request('id'));

        $user->name = request('name');
        $user->email = request('email');
        if (request('password') != null) {
            $user->password = Hash::make(request('password'));
        }
        $user->role = 'worker';
        $user->is_active = request('is_active');

        $user->save();

        return redirect(route('workers.list'))->with('msg', 'Worker account updated');
    }

    public function delete($id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('workers.list'))->with('msg', 'Worker account deleted');
    }
}
