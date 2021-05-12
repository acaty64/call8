<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Trace;

class TraceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Usuario 1. En Window 1. En Pausa
    	Trace::create([
    		'host_id' => 1,
    		'window_id' => 1,
    		'call_id' => null,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    	// Usuario 1. En Window 1. Libre
    	Trace::create([
    		'host_id' => 1,
    		'window_id' => 1,
    		'call_id' => null,
    		'status_id' => 2,
            'office_id' => 1,
    	]);

    	// Usuario 1. En Window 1. Llamando
    	Trace::create([
    		'host_id' => 1,
    		'window_id' => 1,
    		'call_id' => 1,
    		'status_id' => 3,
            'office_id' => 1,
    	]);

    	// Usuario 1. En Window 1. Atendiendo
    	Trace::create([
    		'host_id' => 1,
    		'window_id' => 1,
    		'call_id' => 1,
    		'status_id' => 4,
            'office_id' => 1,
    	]);
    	////////////////////////////////////////
    	// Usuario 2. En Window 2. En Pausa
    	Trace::create([
    		'host_id' => 2,
    		'window_id' => 2,
    		'call_id' => null,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    	// Usuario 2. En Window 2. Libre
    	Trace::create([
    		'host_id' => 2,
    		'window_id' => 2,
    		'call_id' => null,
    		'status_id' => 2,
            'office_id' => 1,
    	]);

    	// Usuario 2. En Window 2. Llamando
    	Trace::create([
    		'host_id' => 2,
    		'window_id' => 2,
    		'call_id' => 2,
    		'status_id' => 3,
            'office_id' => 1,
    	]);

    	// Usuario 2. En Window 2. Atendiendo
    	Trace::create([
    		'host_id' => 2,
    		'window_id' => 2,
    		'call_id' => 2,
    		'status_id' => 4,
            'office_id' => 1,
    	]);
    	////////////////////////////////////////
    	// Usuario 3. En Window 3. En Pausa
    	Trace::create([
    		'host_id' => 3,
    		'window_id' => 3,
    		'call_id' => null,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    	// Usuario 3. En Window 3. Libre
    	Trace::create([
    		'host_id' => 3,
    		'window_id' => 3,
    		'call_id' => null,
    		'status_id' => 2,
            'office_id' => 1,
    	]);
    	////////////////////////////////////////


    	////////////////////////////////////////
    	// Usuario 4. En Llamada 4. En Pausa
    	Trace::create([
    		'client_id' => 4,
    		'window_id' => null,
    		'call_id' => 4,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    	// Usuario 4. En Llamada 4. En Window 1. Atendiendo
    	Trace::create([
    		'client_id' => 4,
    		'window_id' => 1,
    		'call_id' => 4,
    		'status_id' => 4,
            'office_id' => 1,
    	]);

    	////////////////////////////////////////
    	// Usuario 5. En Llamada 5. En Pausa
    	Trace::create([
    		'client_id' => 5,
    		'window_id' => null,
    		'call_id' => 5,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    	// Usuario 5. En Llamada 5. En Window 2. Atendiendo
    	Trace::create([
    		'client_id' => 5,
    		'window_id' => 3,
    		'call_id' => 5,
    		'status_id' => 4,
            'office_id' => 1,
    	]);

    	////////////////////////////////////////
    	// Usuario 6. En Llamada 6. En Pausa
    	Trace::create([
    		'client_id' => 6,
    		'window_id' => null,
    		'call_id' => 6,
    		'status_id' => 5,
            'office_id' => 1,
    	]);

    }
}

