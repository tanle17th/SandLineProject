<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    public function index()
    {
       // $locations = Incident::paginate(15);
        // $incidents = Incident::all();
      //  $incidents = Incident::orderBy('time')->get();
     //   $incidents = Incident::orderBy('time', 'desc')->get();
     //   $incidents = Incident::where('detail', 'testing2 detail')->get();
      //  $incidents = Incident::latest()->get();
        $incidents = Incident::latest()->paginate(5);


      //  return view('incidents.index');
        return view('incidents.index', ['incidents' => $incidents,]);
     
    }

    
    public function create()
    {
        $locations = Location::where('is_active', true)->get();

        return view('incidents.create', ['locations' => $locations,]);
    }

    public function store(Request $request)
    {

        $image = $request->file('file');
        if (is_null($image)){
            $imageName = request('file');
        }else{
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'),$imageName);
        }
        
        $incident = new Incident();

        $incident->user_id = Auth::user()->id;
        $incident->location_id = request('location');
        $incident->date = request('date');
        $incident->time = request('time');
        $incident->detail = request('detail');
        $incident->image = $imageName;
        $incident->comment = request('comment');

        // error_log($incident->save());
        $incident->save();

     if (Auth::user()->role == 'admin') {
            return redirect(route('incidents.list'))->with('mssg', 'Incident added successfully');
        } else {
            return redirect(route('dashboard'))->with('mssg', 'Incident added successfully');
        }
    }

    public function edit($id)
    {
        // use $id to query the db
        $incident = Incident::findOrFail($id);

         $locations = Location::all();

        return view('incidents.edit', [ 'incident' => $incident, 'locations' => $locations ]);  
    }


    public function update(Request $request)
    {     
        $incident = Incident::findOrFail(request('id'));

        $image = $request->file('file');
        if (is_null($image)){
          //  $imageName = request('file');
            $imageName = $incident->image;
        }else if (is_null($incident->image)) {
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'),$imageName);
        }else {
            unlink(public_path('images').'/'.$incident->image);
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'),$imageName);
        }
        
        
        $incident->date = request('date');
        $incident->time = request('time');
        $incident->location_id = request('location');
        $incident->detail = request('detail');
        $incident->image = $imageName;
        $incident->comment = request('comment');
        $incident->is_active = request('is_active');


        $incident->save();

        return redirect(route('incidents.list'))->with('mssg', 'Incident updated');
    }

    public function delete($id)
    {

        $incident = Incident::findOrFail($id);
        
        // remove image from public folder
        if (!is_null($incident->image))
        unlink(public_path('images').'/'.$incident->image);

       error_log("DELETING");
       error_log($incident->image);

        $incident->delete();

       return redirect(route('incidents.list'))->with('mssg', 'Incident deleted');
    }
}
