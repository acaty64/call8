<?php

namespace Tests\Feature;

use App\Http\Livewire\AccessIndex;
use App\Models\Access;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireAccessTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function access_index_page_contains_livewire_component()
    {
        $admin = User::find(1);
        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->assertSeeHtml('Indice de Accesos');

    }

    /** @test */
    public function admin_can_add_access_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Acceso');

        $data = [
            'user_id' => 1,
            'type_id' => 2,
            'office_id' => 1,
        ];

        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->call('setStatus', 'create')
            ->set('user_id', $data['user_id'])
            ->set('type_id', $data['type_id'])
            ->set('office_id', $data['office_id'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('accesses', $data);

    }

    /** @test */
    public function admin_can_update_access_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);

        $data = [
            'user_id' => 1,
            'type_id' => 2,
            'office_id' => 1,
        ];

        $access = Access::create($data);
        $this->assertDatabaseHas('accesses', $data);

        $newData = [
            'user_id' => 1,
            'type_id' => 2,
            'office_id' => 2,
        ];

        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Acceso');

        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->call('setStatus', 'edit', $access->id)
            ->assertSet('type_id', $data['type_id'])
            ->set('office_id', $newData['office_id'])
            ->call('save');

        $this->assertDatabaseHas('accesses', $newData);
        $this->assertDatabaseMissing('accesses', $data);

    }

    /** @test */
    public function admin_can_destroy_a_access_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $access = Access::find(3);

        Livewire::actingAs($admin)
            ->test(AccessIndex::class)
            ->call('setStatus', 'destroy', $access->id)
            ->assertSet('access_id', $access->id)
            ->assertSeeHtml('Acceso a Eliminar')
            ->call('save', 'destroy');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('accesses', $access->toArray());

    }


}
