<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {
        // $incidents = Incident::all();
      //  $incidents = Incident::orderBy('time')->get();
     //   $incidents = Incident::orderBy('time', 'desc')->get();
     //   $incidents = Incident::where('detail', 'testing2 detail')->get();
        $incidents = Incident::latest()->get();


      //  return view('incidents.index');
        return view('incidents.index', ['incidents' => $incidents,]);
     
    }

    public function edit($id)
    {
        // use $id to query the db
        $incident = Incident::findOrFail($id);

        return view('incidents.edit', [ 'incident' => $incident ]);
    
    }

    public function create()
    {
        return view('incidents.create');
    }

    public function store()
    {
        // error_log(request('date'));
        // error_log(request('time'));
        // error_log(request('location'));
        // error_log(request('date'));
        // error_log(request('date'));
        // error_log(request('date'));

         $incident = new Incident();
      
        $incident->date = request('date');
        $incident->time = request('time');
       // $incident->location = request('location');
        $incident->detail = request('detail');
        $incident->image = request('image');
        $incident->comment = request('comment');
        
        // error_log($incident);
         error_log($incident->save());

     //   return redirect('/index')->with('mssg', 'Incident added successfully');
        return redirect(route('dashboard'))->with('mssg', 'Incident added successfully');
    }

    public function update($id)
    {

        request()->validate([
            'date' => 'required',
            'time' => 'required',
            //'location' => 'required',
            'detail' => 'required',
            'image' => 'required',
            'comment' => 'required'
        ]);

        $incident = Incident::findOrFail(request('id'));

        $incident->date = request('date');
        $incident->time = request('time');
       // $incident->location = request('location');
        $incident->detail = request('detail');
        $incident->image = request('image');
        $incident->comment = request('comment');


        $incident->save();

        return redirect(route('incidents.list'))->with('mssg', 'Incident updated');
    }

    public function delete($id)
    {

        $incident = Incident::findOrFail($id);
        $incident->delete();

       return redirect(route('incidents.list'))->with('mssg', 'Incident deleted');
      // return redirect('/index')->with('mssg', 'Incident Deleted');
    }
}
