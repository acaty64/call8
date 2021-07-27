<?php

namespace App\Http\Livewire;

use App\Http\Traits\CallTrait;
use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Window;
use Carbon\CarbonImmutable;
use Livewire\Component;

class DashboardScreen extends Component
{

  use WindowTrait;
  use CallTrait;

	public $hosts;
	public $clients_now;
	public $window_today;
	public $client_today;
  public $offices;
  public $office_id;
  public $schedules;
  public $selected_office;

  protected $listeners = [
      'echo-private:channel-ring,Ring2Event' => 'ring',
      // 'echo-presence:presence-ring,here' => 'here',
      // 'echo-presence:presence-ring,joining' => 'joining',
      'echo-presence:presence-ring,leaving' => 'leaving',
  ];

  public function render()
  {
      return view('livewire.dashboard-screen');
  }

 	public function mount()
 	{
    $this->hosts=[];
    $this->offices = Office::all();
    $this->selected_office = 1;
    $this->getData();
 	}

  public function ring()
  {
    $this->getData();
  }

  public function leaving()
  {
    $this->getData();
  }

  public function updated($field, $value)
  {
      if($field == 'selected_office')
      {
        $this->hosts = Window::where('host_id', '!=', null)->where('office_id', $this->selected_office)->get();
      }
  }

  public function getData()
  {
    $this->hosts = Window::where('host_id', '!=', null)->where('office_id', $this->selected_office)->get();

    $status_paused = Status::where('status', 'En Pausa')->first()->id;
    $this->clients_now = Call::where('status_id',  $status_paused)->get();

    // $this->office_id = 1;
    $this->now = CarbonImmutable::now()->format('Y-m-d');
    $this->hour_now = CarbonImmutable::now()->format('H:i');

    $arrayWhere = [
      ['office_id', $this->selected_office],
      ['date_start', '<=', $this->now],
      ['date_end', '>=', $this->now],
      ['hour_start', '<=', $this->hour_now ],
      ['hour_end', '>=', $this->hour_now ],
    ];

    $this->schedules = Schedule::where($arrayWhere)->get();

// dd($this->schedules);

// dd(date_default_timezone_get(), date('m/d/Y h:i:s a', time()), $this->now, $this->hour_now);

  }

  public function closeWindow($window_id)
  {
    $window = Window::findOrFail($window_id);
    $this->window_out($window->host_id);
    $this->getData();
  }

  public function closeCall($call_id)
  {
    // $call = Call::findOrFail($call_id);
    $this->call_out($call_id);
    $this->getData();
  }



}
