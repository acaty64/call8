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
        	'window' => 'A01',
        	'host_id' => 1,
            'client_id' => 4,
        	'status_id' => 4,
            'call_id' => 1,
            'office_id' => 1,
        ]);
        Window::create([
        	'window' => 'A02',
        	'host_id' => 2,
            'client_id' => null,
        	'status_id' => 5,
            'call_id' => null,
            'office_id' => 1,
        ]);
        Window::create([
        	'window' => 'A03',
        	'host_id' => null,
            'client_id' => null,
        	'status_id' => 1,
            'call_id' => null,
            'office_id' => null,
        ]);
        Window::create([
            'window' => 'A04',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
            'office_id' => null,
        ]);
        Window::create([
            'window' => 'A05',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
            'office_id' => null,
        ]);
        Window::create([
            'window' => 'A06',
            'host_id' => null,
            'client_id' => null,
            'status_id' => 1,
            'call_id' => null,
            'office_id' => null,
        ]);
    }
}
