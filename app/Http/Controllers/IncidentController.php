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

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


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
        // error_log("START CREATE");
        // error_log(request('date'));
        // error_log(request('time'));
        // error_log(request('location'));
        // error_log(request('detail'));
        // error_log(request('file'));
        // error_log(request('comment'));
        // error_log("END CREATE");

        //  request()->validate([
        //         'date' => 'required',
        //         'timer' => 'required',
        //         'location' => 'required',
        //         'detail' => 'required',
        //         'image' => 'required',
        //         'comment' => 'required'
        //     ]);

        $image = $request->file('file');
        if (is_null($image)){
            $imageName = request('image');
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

        
        
       //  error_log($incident);
         error_log($incident->save());

     //   return redirect('/index')->with('mssg', 'Incident added successfully');
        return redirect(route('dashboard'))->with('mssg', 'Incident added successfully');
     //   return redirect(route('incidents.list'))->with('mssg', 'Incident updated');
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
        // error_log("START UPDATE");

        // error_log(request('date'));
        // error_log(request('time'));
        // error_log(request('location'));
        // error_log(request('detail'));
        // error_log(request('file'));
        // error_log(request('comment'));

        // request()->validate([
        //     'date' => 'required',
        //     'time' => 'required',
        //     'location' => 'required',
        //     'detail' => 'required',
        //     'image' => 'required',
        //     'comment' => 'required'
        // ]);

        // error_log("END UPDATE");

        // $image = $request->file('file');
        // $imageName = time().'.'.$image->extension();
        // $image->move(public_path('images'),$imageName);

        $image = $request->file('file');
        if (is_null($image)){
            $imageName = request('image');
        }else{
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'),$imageName);
        }
        
        error_log("YES");
        error_log($image);

        $incident = Incident::findOrFail(request('id'));
        

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
      // return redirect('/index')->with('mssg', 'Incident Deleted');
    }
}
