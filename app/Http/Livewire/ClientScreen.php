<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use App\Http\Traits\CallTrait;
use App\Http\Traits\ScheduleTrait;
use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Link;
use App\Models\Office;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ClientScreen extends Component
{
    use CallTrait;
    use ScheduleTrait;

	public $screen;
    public $office_id;

    public $office;
    public $horario;
    public $horarios;

    public $message;
    public $qclients;
	public $qwindows;
	public $status;
    public $window;
    public $data_test;
    public $call_id;
    public $host_id;
    public $user;
    public $others;
    public $client;
    public $host;
    public $links;
    public $custom_time;

    public $f_message;

    protected $listeners = [
        'echo-private:channel-ring,Ring2Event' => 'ring',
        'echo-presence:presence-ring,here' => 'here',
        'echo-presence:presence-ring,joining' => 'joining',
        'echo-presence:presence-ring,leaving' => 'leaving',
    ];

    public function mount()
    {
        $this->screen = "welcome";
        $this->office_id = "";
        $this->data_test = "";
        $this->status = "";
        $this->message = "Bienvenido, seleccione la oficina con la que desea comunicarse.";
        $this->call_id = null;
        $this->start();
        $this->client = \Auth::user();
        $this->horario = [];
        $this->getHorarios();
        $this->links = Link::where('active', 1)->orderBy('order')->get();
        $this->f_message = "mount()";
    }

    public function watch()
    {
        $this->custom_time = Carbon::now()->format('H:i:s');
    }

    public function render()
    {
        $this->watch();
        return view('livewire.client-screen');
    }

    public function here()
    {
        $this->watch();
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function joining()
    {
        $this->watch();
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function leaving($data)
    {
        $this->watch();
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function start()
    {
        $this->watch();
        $call = Call::where('client_id', \Auth::user()->id)->where('status_id', '>', 1)->first();
        if($call){
            $this->call_id = $call->id;
            $this->office_id = $call->office_id;
            if($call->window){
                $this->message = $call->window->mensaje;
                $this->status = $call->window->status->status;
                $this->host = $call->window->host;
            }else{
                $status = Status::find($call->status_id);
                $this->status = $status->status;
                $this->message = $status->status;
            }
            $this->f_message = "start()";
        }
    }

    public function ring($data)
    {
        $this->watch();
        if($data['message']){
            if($data['message'] == 'Connecting'){
                $this->f_message = "watch() connecting";
                $this->host = User::find($data['host_id']);
                $users = [
                    'user' => $this->client,
                    'other' => $this->host,
                ];
                return redirect('/video_chat/' . $users['user']->id . '/' . $users['other']->id . '/'. $data['call_id']);
            }
        }

        if($this->call_id > 0){
            $call = Call::find($this->call_id);
            $this->status = $call->status->status;
            $this->f_message = "watch() call_id>0";
        // }

        // if($data['call_id'] == $this->call_id && !is_null($data['call_id'])){
            $this->message = $data['message'];
            // $this->message = $call->window->mensaje;
            $this->f_message = "watch() data[call_id] == this->call_id";
        }

        if($this->status == 'Llamando'){
            $this->sound(true);
        }

        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;

    }

    public function wait()
    {
        $this->watch();
        $this->status = 'En Pausa';
        $response = $this->call_open($this->office_id);
        $this->call_id = $response['id'];
        $this->message = 'Está en cola';
        $this->f_message = "wait()";
    }

    public function answer()
    {
        $this->sound(false);
        $this->watch();
        $this->message = 'Conectando ...., espere.';
        $response = $this->call_answer($this->call_id);
        $this->status = $response['status'];
        $this->f_message = "answer()";
    }

    public function stop()
    {
        $this->watch();
        $this->message = 'Desconectando ....';
        $response = $this->call_close();
        $this->status = 'Cerrado';
        $this->message = 'Desconectado';
        $this->f_message = "stop()";

    }

    public function updated($variable, $value)
    {
        $this->watch();
        if($variable == 'office_id')
        {
            $this->office = Office::find($value);
            $this->horary = $this->horary(1);
        }

    }

    public function getHorarios()
    {

        $this->watch();
        $offices = Office::all();
        $today = CarbonImmutable::now()->dayOfWeek;

        $array = [];
        $array['today'] = [
            'date' => CarbonImmutable::now()->isoformat('dddd') . ' ' . CarbonImmutable::now()->format('d-m-Y'),
            'offices' => [],
        ];
        foreach ($offices as $office) {
            $horary = $this->horary_office($office->id, $today);
            if($horary){
                foreach($horary as $franja)
                {
                    $hour_now = Carbon::now()->format('H:i');
                    // $hour_now = Carbon::now()->format('H') . ":" . Carbon::now()->format('i');

                    if($franja['fin'] >= $hour_now)
                    {
                        $array['today']['offices'][$office->name]['id'][] = $office->id;
                        $array['today']['offices'][$office->name]['horarios'][] = $franja;
                    }
                }
            }
        };

        if($array['today']['offices'] == []){
            $this->message = 'No hay operadores programados, revise los horarios de atención.';
            $this->f_message = "getHorarios()";
        }


        $tomorrow = CarbonImmutable::now()->dayOfWeek + 1;

        $array['tomorrow'] = [
            'date' => CarbonImmutable::now()->addDays(1)->isoformat('dddd') . ' ' . CarbonImmutable::now()->addDays(1)->format('d-m-Y'),
            'offices' => [],
        ];
        foreach ($offices as $office) {
            $horary = $this->horary_office($office->id, $tomorrow);
            if($horary){
                foreach($horary as $franja)
                {
                    $array['tomorrow']['offices'][$office->name] = [
                        'horarios' => $horary,
                    ];
                }
            }
        }

        $this->horarios = $array;
    }

    public function setOfficeId($value)
    {
        $this->watch();
        $this->office_id = $value;
        $this->message = "Póngase en cola y espere a ser llamado.";
    }

    public function sound($switch)
    {
        // $this->emit('sound_play');
        $this->emit('sound_play', $switch);
    }

}

