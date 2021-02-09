<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WorklogController;
use App\Http\Controllers\WorklogsExportController;
use Facade\FlareClient\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('dashboard'));
});

// Disable registration module
Auth::routes([
    'register' => false
]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/worklogs', function () { return view('old.manage_worklogs'); })->name('worklog.list');
// Route::get('/worklogs/add', function () { return view('old.add-worklog'); })->name('worklog.add')->middleware('auth.worker');
// Route::get('/services', function () { return view('old.manage_services'); })->name('service.list');
// Route::get('/locations', function () { return view('old.manage_locations'); })->name('location.list');

Route::get('/workers', [WorkerController::class, 'index'])->name('workers.list')->middleware('auth.admin');
Route::get('/workers/create', [WorkerController::class, 'create'])->name('workers.create')->middleware('auth.admin');
Route::post('/workers', [WorkerController::class, 'store'])->name('workers.store')->middleware('auth.admin');
Route::get('/workers/{id}', [WorkerController::class, 'edit'])->name('workers.edit')->middleware('auth.admin');
Route::post('/workers/{id}', [WorkerController::class, 'update'])->name('workers.edit')->middleware('auth.admin');
Route::delete('/workers/{id}', [WorkerController::class, 'delete'])->name('workers.delete')->middleware('auth.admin');

Route::get('/services', [ServiceController::class, 'index'])->name('services.list')->middleware('auth.admin');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create')->middleware('auth.admin');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store')->middleware('auth.admin');
Route::get('/services/{id}', [ServiceController::class, 'edit'])->name('services.edit')->middleware('auth.admin');
Route::post('/services/{id}', [ServiceController::class, 'update'])->name('services.edit')->middleware('auth.admin');
Route::delete('/services/{id}', [ServiceController::class, 'delete'])->name('services.delete')->middleware('auth.admin');

Route::get('/locations', [LocationController::class, 'index'])->name('locations.list')->middleware('auth.admin');
Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create')->middleware('auth.admin');
Route::post('/locations', [LocationController::class, 'store'])->name('locations.store')->middleware('auth.admin');
Route::get('/locations/{id}', [LocationController::class, 'edit'])->name('locations.edit')->middleware('auth.admin');
Route::post('/locations/{id}', [LocationController::class, 'update'])->name('locations.edit')->middleware('auth.admin');
Route::delete('/locations/{id}', [LocationController::class, 'delete'])->name('locations.delete')->middleware('auth.admin');

Route::get('/worklogs', [WorklogController::class, 'index'])->name('worklogs.list');
Route::get('/worklogs/create', [WorklogController::class, 'create'])->name('worklogs.create');
Route::get('/worklogs/filtered/{worker_id}', [WorklogController::class, 'worklogsOfWorker'])->name('worklogs.list.filtered.by.worker')->middleware('auth.admin');
Route::get('/worklogs/filtered', [WorklogController::class, 'worklogsFilteredByDate'])->name('worklogs.list.filtered.by.date')->middleware('auth.admin');
Route::get('/worklogs/export', [WorklogController::class, 'export'])->name('worklogs.list.export')->middleware('auth.admin');
Route::post('/worklogs', [WorklogController::class, 'store'])->name('worklogs.store');
Route::get('/worklogs/{id}', [WorklogController::class, 'edit'])->name('worklogs.edit')->middleware('auth.admin');
Route::post('/worklogs/{id}', [WorklogController::class, 'update'])->name('worklogs.edit')->middleware('auth.admin');
Route::delete('/worklogs/{id}', [WorklogController::class, 'delete'])->name('worklogs.delete')->middleware('auth.admin');



Route::get('/test', function () {

    // return Illuminate\Support\Facades\Hash::make('test@123');
    // return "For testing purpose.";

    // return view('worklogs.create_autocomplete');

    // $worklogs = App\Models\Location::find(2)->worklogs;

    // foreach($worklogs as $worklog){
    //     echo $worklog->comment;
    // }

    // $add = App\Models\Worklog::find(3)->services;

    // foreach($add as $s){
    //     echo "<br>" . $s->name;
    // }
});
