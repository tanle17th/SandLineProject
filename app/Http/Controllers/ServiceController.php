<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get data from databases
        // $services = Service::all();
        // $services = Service::orderBy('name', 'desc')->get();
        $services = Service::orderBy('name')->paginate(15);

        return view('services.index', [
            'services' => $services
        ]);
    }

    public function edit($id)
    {
        // use $id to query the db
        $service = Service::findOrFail($id);

        return view('services.edit', [
            'service' => $service
        ]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store()
    {

        request()->validate([
            'name' => 'required'
        ]);

        $service = new Service();

        $service->name = request('name');
        $service->is_active = request('is_active');

        $service->save();

        return redirect(route('services.list'))->with('msg', 'New service added');
    }

    public function update($id)
    {

        request()->validate([
            'name' => 'required'
        ]);

        $service = Service::findOrFail(request('id'));

        $service->name = request('name');
        $service->is_active = request('is_active');

        $service->save();

        return redirect(route('services.list'))->with('msg', 'Service updated');
    }

    public function delete($id)
    {

        $service = Service::findOrFail($id);
        $service->delete();

        return redirect(route('services.list'))->with('msg', 'Service deleted');
    }
}
