<?php

namespace App\Http\Livewire;

use App\Events\Ring2Event;
use App\Events\RingEvent;
use App\Http\Traits\CallTrait;
use App\Http\Traits\ScheduleTrait;
use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Link;
use App\Models\Office;
use App\Models\Schedule;
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
        $response = broadcast(new Ring2Event([
            'window_id'=> null,
            'host_id' => null,
            'client_id' => $this->client->id,
            'call_id' => $this->call_id,
            'office_id' => null,
            'message' => 'Test Channel.'
        ]));
    }

    public function mount()
    {
        $this->screen = "welcome";
        $this->office_id = null;
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
        $this->watch();
        return view('livewire.client-screen');
    }

    public function here()
    {
        $this->watch();
    }

    public function joining()
    {
        $this->watch();
    }

    public function leaving($data)
    {
        $this->watch();
    }

    public function start()
    {
        $this->watch();
        $call = Call::whereDate('created_at', now())
                    ->where('client_id', \Auth::user()->id)
                    ->where('status_id', '>', 1)->first();
        if($call){
            $this->call_id = $call->id;
            $this->office_id = $call->office_id;
            if($call->window){
                $this->window = $call->window;
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

    public function channelData($data)
    {
        $this->watch();
    }

    public function ring($data)
    {
        $this->watch();
        // if( $data['call_id'] == $this->call_id ){
            if( $data['message'] == 'Connecting' ){
                $this->f_message = "watch() connecting";
                $this->host = User::find($data['host_id']);
                $users = [
                    'user' => $this->client,
                    'other' => $this->host,
                ];
                return redirect('/video_chat/' . $users['user']->id . '/' . $users['other']->id . '/'. $data['call_id']);
            }

            if( !is_null($data['call_id']) ){
                $call = Call::find($this->call_id);
                $this->status = $call->status->status;
                $this->f_message = "watch() call_id>0";

                $this->message = $data['message'];

                if($this->status == 'Llamando'){
                    $this->sound(true);
                }

                if($this->status == 'Cerrado'){
                    $this->sound(false);
                }
            }
        // }

        $this->watch();
    }

    public function wait()
    {
        $this->watch();
        $this->status = 'En Pausa';
        $response = $this->call_open($this->office_id);
        $this->call_id = $response['id'];
        $this->message = 'Está en cola';
        $this->f_message = "wait()";

        return redirect()->to(route('call.client'));
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
        $this->sound(false);
        $this->message = 'Desconectando ....';
        $response = $this->call_close();
        $this->status = 'Cerrado';
        $this->message = 'Desconectado';
        $this->f_message = "stop()";
        $this->redirect(route('stop.call'));
    }

    public function updated($variable, $value)
    {
        $this->watch();
        if($variable == 'office_id')
        {
            $this->office = Office::findOrFail($value);
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
        $this->emit('sound_play', $switch);
    }

}