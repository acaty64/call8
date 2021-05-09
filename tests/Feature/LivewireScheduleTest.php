<?php

namespace Tests\Feature;

use App\Http\Livewire\HostScreen;
use App\Http\Livewire\ScheduleScreen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireScheduleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function schedule_page_contains_livewire_component()
    {
        $host = User::find(1);
        $hoy = new Carbon();
        if($hoy->dayOfWeek == 0){
            $lunes = $hoy->addDay();
        }else{
            $lunes = $hoy->subDays($hoy->dayOfWeek);
        }
        $domingo = $lunes->addDays(6);
        Livewire::actingAs($host)
            ->test(ScheduleScreen::class)
            ->assertSeeHtml('Fecha de inicio')
            ->assertSeeHtml($lunes->format('Y-m-d'))
            ->assertSeeHtml('Fecha de fin')
            ->assertSeeHtml($domingo->format('Y-m-d'));

    }






}
