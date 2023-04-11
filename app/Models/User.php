<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MessageSent;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function save(array $options = [])
    {
        $this->attributes['password'] = $this->attributes['password'];
        return parent::save($options);
    }

    public function delete()
    {
        // TODO: Perform any additional actions you need before deleting the user.
        // For example, you might want to delete any related records in other tables.
        // Then call the parent delete method to delete the user record from the database.

        return parent::delete();
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'created_by');
    }

    public function routeNotificationForOneSignal() : array{
        return ['tags'=>['key'=>'userId','relation'=>'=', 'value'=>(string)($this->id)]];
    }

    public function sendNewMessageNotification(array $data) : void {
        $this->notify(new MessageSent($data));
    }
}
