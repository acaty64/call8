<?php
namespace Database\Seeders;

use App\Models\Link;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::create([
            'order' => 1,
            'name' => 'DAIA - Trámites',
            'description' => 'Si usted desea realizar los siguientes trámites: Actualización de matrícula, ...',
            'link' => 'https://forms.gle/jHsR3cYJe5MoGoyK8',
            'active' => 1,
        ]);

        Link::create([
            'order' => 2,
            'name' => 'Bienestar Universitario - Ficha Socioeconómica',
            'description' => 'Para ingresar sus datos socioeconómicos.',
            'link' => 'https://forms.gle/jHsR3cYJe5MoGoyK8',
            'active' => 1,
        ]);

    }
}
