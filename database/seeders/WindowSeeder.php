<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Window;

class WindowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Window::create([
        	'window' => 'A1',
        	'host_id' => 1,
            'client_id' => 4,
        	'status_id' => 4,
            'call_id' => 1,
        ]);
        Window::create([
        	'window' => 'A2',
        	'host_id' => 2,
            'client_id' => 5,
        	'status_id' => 4,
            'call_id' => 2,
        ]);
        Window::create([
        	'window' => 'A3',
        	'host_id' => 3,
            'client_id' => null,
        	'status_id' => 5,
            'call_id' => null,
        ]);
        Window::create([
            'window' => 'A4',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
        ]);
        Window::create([
            'window' => 'A5',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
        ]);
        Window::create([
            'window' => 'A6',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
        ]);
    }
}
