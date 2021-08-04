<?php
 
namespace App\Http\Livewire;

use App\Events\Ring2Event;
use App\Events\RingEvent;
use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;

class HostScreen extends Component
{

    use WindowTrait;

    public $screen;
	public $office_id;
    public $qwindows;
    public $qclients;
	public $status;
    public $window;
    public $call_id;
    public $data_test;
    public $message;
    public $client;
    public $host;
    public $program;
    public $custom_time;
    public $office;
    public $channelName;


    public function getListeners()
    {
        $this->channelName = "echo:channel-ring-{$this->call_id}";
        return [
            "echo:channel-ring-{$this->call_id},Ring2Event" => 'ring',
            "echo:channel-data,RingEvent" => 'channelData',
            "echo:channel-data,here" => 'here',
            "echo:channel-data,joining" => 'joining',
            "echo:channel-data,leaving" => 'leaving',
        ];
    }

    public function test_channel(){
        $call = Call::all()->sortByDesc('id')->first();
        $response = broadcast(new Ring2Event([
            'window_id'=> null,
            'host_id' => null,
            'client_id' => null,
            'call_id' => $call->id,
            'office_id' => null,
            'message' => 'Test Channel.'
        ]));
    }

    public function channelData($data)
    {
        $this->watch();
    }


    public function mount()
    {
        // $window = new Window;
        $this->office_id = null;
        $this->call_id = null;
        $this->data_test = "";
        $this->status = "";
        // $this->link = "";
        $this->message = "";
        $this->window = [];
        $this->screen = 'close';
        $this->openWindow();
        $this->getProgram();
        $this->getListeners();
    }

    public function watch()
    {
        $this->custom_time = Carbon::now()->format('H:i:s');
        $w = new Window;
        if($this->office_id){
            $this->qclients = $w->qclients($this->office_id);
            $this->qwindows = $w->qwindows($this->office_id);
            $this->office = Office::findOrFail($this->office_id);
        }else{
            $this->qclients = $w->qclients();
            $this->qwindows = $w->qwindows();
        }
    }

    public function render()
    {
        $this->host = \Auth::user();
        $this->watch();
        return view('livewire.host-screen');
    }

    public function here()
    {
        $this->watch();
        // $this->message = 'here';
    }

    public function connect()
    {
        $window = Window::find($this->host->window->id);
        $window->mensaje = 'Connecting';
        $window->save();

        broadcast(new Ring2Event([
            'window_id'=> $window->id,
            'host_id' => $window->host_id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'office_id' => $window->office_id,
            'message' => 'Connecting'
        ]));

        $this->client = $this->host->window->client;
        $users = [
            'user' => $this->host,
            'other' => $this->client,
        ];
        return redirect('/video_chat/' . $users['user']->id . '/' . $users['other']->id . '/' . $window->call_id);
    }

    public function joining()
    {
        $this->watch();
    }

    public function leaving($data)
    {
        $this->watch();
    }

    public function ring($data)
    {
        // if($data['call_id'] == $this->window->call_id)
        // {
            $window = Window::where('host_id', \Auth::user()->id)->first();
            $this->window = $window;
            $this->status = $window->status->status;
            $this->message = $window->mensaje;
            // $this->link = $window->link;
        // }
        $this->watch();
    }

    public function openWindow()
    {
        $this->watch();
        $this->data_test = 'function openWindow';

        $window = $this->window_open();

        if($window)
        {
            $this->window = $window;
            $this->status = $window->status->status;
            $this->message = $this->status;
            $this->office_id = $window->office_id;
            $this->call_id = $window->call_id;
            $this->screen = 'open';

            return true;
        }
        $this->screen = 'close';
    }

    public function startWindow()
    {
        $this->data_test = 'function startWindow';
        $response = $this->window_start();
        $this->window = $response;
        $this->status = $response->status->status;
        // $this->link = $response->link;
        // if(!$response->client_id){
        //     $this->message = $response->link;
        // }else{
        if($response->client_id){
            $this->message = "Llamando a " . $response->client->given_name;
            $this->client = User::find($response->client->id);
            $this->call_id = $response->call_id;
            // $this->getListeners();
            return redirect()->to(route('call.host'));
        }
    }

    public function free()
    {
        $this->data_test = 'function free';
        $response = $this->window_free();
        $this->window = $response;
        $this->status = $response->status->status;
        // $this->link = $response->link;
        $this->message = $this->status;
    }

    public function stopWindow()
    {
        $this->message = 'Desconectando ....';
        $this->data_test = 'function stopWindow';
        $response = $this->window_stop($this->host->id);
        $this->window = $response;
        $this->status = $response->status->status;
        // $this->link = $response->link;
        $this->message = $this->status;
    }

    public function pauseWindow()
    {
        $this->data_test = 'function pausepWindow';
        $response = $this->window_paused();
        $this->window = $response;
        $this->status = $response->status->status;
        // $this->link = $response->link;
        $this->message = $this->status;
    }

    public function outWindow()
    {
        $this->message = 'Saliendo ....';
        $this->data_test = 'function outWindow';
        $response = $this->window_out();
        $this->window = $response;
        $this->status = $response->status->status;
        // $this->link = $response->link;
        $this->message = $this->status;

        return redirect('/stop/host');

    }

    public function getProgram()
    {
        $f_ini = CarbonImmutable::now();
        $f_fin = CarbonImmutable::now()->addDays(6);

        $days = [];
        for ($i=0; $i < 7; $i++) {
            $f = $f_ini->addDays($i)->format('Y-m-d');
            $days[] = $f;
        }

        $program = [];
        foreach ($days as $key => $day) {
            $dia = CarbonImmutable::create($day);
            $diaSemana = $dia->dayOfWeek;
            $schedules = Schedule::where('date_start', '<=', $day )
                        ->where('date_end', '>=', $day)
                        ->where('day', $diaSemana)
                        ->where('host_id', \Auth::user()->id)
                        ->get();
            foreach ($schedules as $schedule) {
                $program[] = [
                    'fecha' => $dia->isoformat('dddd') . ' ' . $dia->format('d-m-Y'),
                    'hora_ini' => $schedule->hour_start,
                    'hora_fin' => $schedule->hour_end,
                ];
            }
        }

        $this->program = $program;
    }

}

