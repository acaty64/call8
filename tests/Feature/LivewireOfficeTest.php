<?php

namespace Tests\Feature;

use App\Http\Livewire\OfficeIndex;
use App\Models\Office;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function office_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->assertSeeHtml('Siglas')
            ->assertSeeHtml('Nombre')
            ;

    }

    /** @test */
    public function master_can_add_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nueva Oficina');

        $data = [
            'code' => 'NEW',
            'name' => 'Nueva Oficina',
        ];

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->call('setStatus', 'create')
            ->set('code', $data['code'])
            ->set('name', $data['name'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('offices', $data);

    }

    /** @test */
    public function master_can_update_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'code' => 'OFF',
            'name' => 'Oficina Test',
        ];

        $office = Office::create($data);
        $this->assertDatabaseHas('offices', $data);

        $newData = [
            'code' => 'NEW',
            'name' => 'Nueva Oficina',
        ];

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Oficina');

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->call('setStatus', 'edit', $office->id)
            ->assertSet('code', $data['code'])
            ->set('code', $newData['code'])
            ->set('name', $newData['name'])
            ->call('save');

        $this->assertDatabaseHas('offices', $newData);
        $this->assertDatabaseMissing('offices', $data);

    }

    /** @test */
    public function master_can_destroy_a_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $office = Office::find(3);

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->call('setStatus', 'destroy', $office->id)
            ->assertSet('office_id', $office->id)
            ->assertSeeHtml('Oficina a Eliminar')
            ->call('save', 'destroy');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('offices', $office->toArray());

    }


}
