<?php
namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'master',
            'acronym' => 'master',
        ]);

        Type::create([
            'name' => 'Administrador',
            'acronym' => 'admin',
        ]);

        Type::create([
            'name' => 'Operador',
            'acronym' => 'host',
        ]);

    }
}
