<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get data from databases
        // $locations = Location::all();
        $locations = Location::paginate(15);
        // $locations = Location::orderBy('name', 'desc')->get();
        // $locations = Location::orderBy('name')->get();

        return view('locations.index', [
            'locations' => $locations
        ]);
    }

    public function edit($id)
    {
        // use $id to query the db
        $location = Location::findOrFail($id);

        return view('locations.edit', [
            'location' => $location
        ]);
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store()
    {

        request()->validate([
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'country' => 'required'
        ]);

        $location = new Location();

        $location->address = request('address');
        $location->city = request('city');
        $location->province = request('province');
        $location->zipcode = request('zipcode');
        $location->country = request('country');
        $location->is_active = request('is_active');

        $location->save();

        return redirect(route('locations.list'))->with('msg', 'New location added');
    }

    public function update($id)
    {

        request()->validate([
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'country' => 'required'
        ]);

        $location = Location::findOrFail(request('id'));

        $location->address = request('address');
        $location->city = request('city');
        $location->province = request('province');
        $location->zipcode = request('zipcode');
        $location->country = request('country');
        $location->is_active = request('is_active');

        $location->save();

        return redirect(route('locations.list'))->with('msg', 'Location updated');
    }

    public function delete($id)
    {

        $location = Location::findOrFail($id);
        $location->delete();

        return redirect(route('locations.list'))->with('msg', 'Location deleted');
    }
}
