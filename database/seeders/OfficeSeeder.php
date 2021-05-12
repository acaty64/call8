<?php
namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Office::create([
			'code' => 'DAIA',
    		'name' => 'Oficina de Asuntos Académicos',
		]);

		Office::create([
			'code' => 'BU',
    		'name' => 'Bienestar Universitario',
		]);

		Office::create([
			'code' => 'FCEC',
    		'name' => 'Facultad de Ciencias Económicas y Comerciales',
		]);


    }
}
