<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class IncidentController extends Controller
{
    /**
     * method that returns index view with all the incidents from the database as a list
     */
    public function index()
    {
       
       // Retrieving data from database
        $incidents = Incident::where('is_active', true)->paginate(5);
        
        // $incidents = Incident::latest()->paginate(5);

        return view('incidents.index', ['incidents' => $incidents,]);
    }


    /**
     * method that returns the create view with create form for new incident creation
     * it is invoked by route->name('incidents.create');
     */
    public function create()
    {
        //retrieving all locations from the database
        $locations = Location::where('is_active', true)->get();

        return view('incidents.create', ['locations' => $locations,]);
    }


    /**
     * method that retrieves user's input from create form,
     * instantiate a new incident, set the new incident with the input values
     * and stores the new incident in the database
     */
    public function store(Request $request)
    {

        //create name for uploaded image
        $image = $request->file('file');
        if (is_null($image)) {
            $imageName = request('file');
        } else {
            //create name by concatenating timestamp and image extension
            $imageName = time() . '.' . $image->extension();
            //save image to images folder under public folder
            $image->move(public_path('images'), $imageName);
        }

        //instantiate new incident
        $incident = new Incident();

        //set new incident with values retrieved from create form
        $incident->user_id = Auth::user()->id;
        $incident->location_id = request('location');
        $incident->date = request('date');
        $incident->time = request('time');
        $incident->detail = request('detail');
        $incident->image = $imageName;
        $incident->comment = request('comment');

        //store new incident in the database
        $incident->save();

        if (Auth::user()->role == 'admin') {
            return redirect(route('incidents.list'))->with('mssg', 'Incident added successfully');
        } else {
            return redirect(route('dashboard'))->with('mssg', 'Incident added successfully');
        }
    }

    /**
     * method that returns the edit view with edit form
     */
    public function edit($id)
    {
        // use id to query data
        $incident = Incident::findOrFail($id);

        //retrieving all locations from the database
        $locations = Location::all();

        return view('incidents.edit', ['incident' => $incident, 'locations' => $locations]);
    }


    /**
     * method that retrieves user's input from edit form,
     * set the current incident with the input values
     * and stores the updated incident in the database
     */
    public function update(Request $request)
    {   
        //get current incident
        $incident = Incident::findOrFail(request('id'));

        //create name for uploaded image
        $image = $request->file('file');
        if (is_null($image)) {
            $imageName = $incident->image;
        } else if (is_null($incident->image)) {
            //create name by concatenating timestamp and image extension
            $imageName = time() . '.' . $image->extension();
            //save image to images folder under public folder
            $image->move(public_path('images'), $imageName);
        } else {
            //delete image from images folder under public folder
            unlink(public_path('images') . '/' . $incident->image);
            //create name by concatenating timestamp and image extension
            $imageName = time() . '.' . $image->extension();
            //save image to images folder under public folder
            $image->move(public_path('images'), $imageName);
        }

        //set current incident with values from edit form
        $incident->date = request('date');
        $incident->time = request('time');
        $incident->location_id = request('location');
        $incident->detail = request('detail');
        $incident->image = $imageName;
        $incident->comment = request('comment');
        $incident->is_active = request('is_active');


        //store updated incident in th database
        $incident->save();

        return redirect(route('incidents.list'))->with('mssg', 'Incident updated');
    }

    public function delete($id)
    {
        // use id to query data
        $incident = Incident::findOrFail($id);

        // remove image from public folder
        if (!isEmpty($incident->image))
            //delete image from images folder under public folder
            unlink(public_path('images') . '/' . $incident->image);

        //remove incident from the database
        $incident->delete();

        return redirect(route('incidents.list'))->with('mssg', 'Incident deleted');
    }


    /**
     * method that returns index view with all the incidents base on type from the database as a list
     */
    public function filteredIncidents()
    {

        $type = request('incident_type');

        switch ($type) {
                case "all":
                   $incidents = Incident::orderBy('is_active', 'desc')->paginate(5);
                    break;
                case "unresolved":
                   $incidents = Incident::where('is_active', true)->paginate(5);
                    break;
                case "resolved":
                   $incidents = Incident::where('is_active', false)->paginate(5);
                    break;
                default:
                    $incidents = Incident::where('is_active', true)->paginate(5);
          }

    return view('incidents.index', ['incidents' => $incidents]);
    }
}
