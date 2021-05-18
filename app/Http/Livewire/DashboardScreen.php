<?php

namespace App\Http\Livewire;

use App\Models\Call;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Window;
use Carbon\CarbonImmutable;
use Livewire\Component;

class DashboardScreen extends Component
{
	public $hosts_now;
	public $clients_now;
	public $window_today;
	public $client_today;
  public $offices;
  public $office_id;
  public $schedules;

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

  public function getData()
  {
    $this->hosts_now = Window::where('host_id', '!=', null)->get();
    $status_paused = Status::where('status', 'En Pausa')->first()->id;
    $this->clients_now = Call::where('status_id',  $status_paused)->get();

    $this->office_id = 1;
    $this->now = CarbonImmutable::now()->format('Y-m-d');
    $this->hour_now = CarbonImmutable::now()->format('H:i');

    $arrayWhere = [
      ['office_id', $this->office_id],
      ['date_start', '<=', $this->now],
      ['date_end', '>=', $this->now],
      ['hour_start', '<=', $this->hour_now ],
      ['hour_end', '>=', $this->hour_now ],
    ];

    $this->schedules = Schedule::where($arrayWhere)->get();

// dd($this->schedules);

// dd(date_default_timezone_get(), date('m/d/Y h:i:s a', time()), $this->now, $this->hour_now);

  }





}
