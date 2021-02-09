<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Delete all the table data first
        DB::table('service_worklog')->delete();
        DB::table('worklogs')->delete();
        DB::table('services')->delete();
        DB::table('locations')->delete();
        DB::table('users')->delete();

        // Adding one admin account
        $user = new User();
        $user->name = 'Ivy';
        $user->email = 'ivy@gmail.com';
        $user->password = Hash::make('test@123');
        $user->role = 'admin';
        $user->save();
        $this->command->info('Added one Admin User!');

        // Adding two worker account
        $user = new User();
        $user->name = 'John';
        $user->email = 'john@gmail.com';
        $user->password = Hash::make('test@123');
        $user->save();
        $user = new User();
        $user->name = 'Max';
        $user->email = 'max@gmail.com';
        $user->password = Hash::make('test@123');
        $user->save();
        $this->command->info('Added two worker users!');

        // Services
        $service = new Service();
        $service->name = 'Snow Removal';
        $service->save();
        $service = new Service();
        $service->name = 'Salt Application';
        $service->save();
        $this->command->info('Added some Services!');

        // Locations
        $location = new Location();
        $location->address = '1385 Woodroffe Ave';
        $location->city = 'Ottawa';
        $location->province = 'ON';
        $location->zipcode = 'K2G 1V8';
        $location->country = 'Canada';
        $location->save();
        $location = new Location();
        $location->address = '1000 Airport Parkway Private';
        $location->city = 'Ottawa';
        $location->province = 'ON';
        $location->zipcode = 'K1V 9B4';
        $location->country = 'Canada';
        $location->save();
        $location = new Location();
        $location->address = 'Wellington St';
        $location->city = 'Ottawa';
        $location->province = 'ON';
        $location->zipcode = 'K1A 0A9';
        $location->country = 'Canada';
        $location->save();
        $this->command->info('Added some Locations!');


    }
}
