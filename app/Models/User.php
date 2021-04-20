<?php

namespace App\Models;


use App\Models\Call;
use App\Models\Status;
use App\Models\Window;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = ['is_host', 'is_client', 'is_paused', 'is_free', 'is_busy', 'is_calling'];

    public function getIsHostAttribute()
    {
        $window = Window::where('host_id', $this->id)->get();
        if($window->count() == 0){
            return false;
        }
        return true;
    }

    public function getIsClientAttribute()
    {

        $status = Status::where('status', 'Cerrado')->first();

        $users = Call::where('user_id', $this->id)->where('status_id', '!=', $status->id)->get();
        if($users->count() == 0){
            return false;
        }
        return true;
    }

    public function getIsFreeAttribute()
    {
        $status = Status::where('status', 'Libre')->first();
        $window = Window::where([
                'host_id' => $this->id,
                'status_id' => $status->id,
            ])->get();

        if($window->count() == 0){
            return false;
        }
        return true;
    }

    public function getIsCallingAttribute()
    {
        $status = Status::where('status', 'Llamando')->first();
        $window = Window::where([
                'host_id' => $this->id,
                'status_id' => $status->id,
            ])->get();

        if($window->count() == 0){
            return false;
        }
        return true;
    }

    public function getIsBusyAttribute()
    {
        $status = Status::where('status', 'Atendiendo')->first();
        $window = Window::where([
                'host_id' => $this->id,
                'status_id' => $status->id,
            ])->get();

        if($window->count() == 0){
            return false;
        }
        return true;
    }

    public function getIsPausedAttribute()
    {
        $status = Status::where('status', 'En Pausa')->first();
        $call = Call::where([
                'user_id' => $this->id,
                'status_id' => $status->id,
            ])->get();

        if($call->count() == 0){
            return false;
        }
        return true;
    }

}
