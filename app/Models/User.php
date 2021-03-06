<?php

namespace App\Models;

use App\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * Переопределяет текст нотайс верификации почты
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }

    /**
     * Переопределяет адрес доставки почты для верификации
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return env('SYSTEM_MAIL');
    }

}
