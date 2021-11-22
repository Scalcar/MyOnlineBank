<?php

namespace App\Models;

use App\General\Concretes\Enums\UserGenders;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fname',
        'lname',
        'gender',
        'dob',
        'cnp',
        'email',
        'phone',
        'address',
        'username',
        'password',
        'admin_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cnp',
        'admin_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class,'list_id');
    }

    public function sent()
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    public function received()
    {
        return $this->hasMany(Message::class,'sent_to_id');
    }

    public function getGenderNameAttribute()
    {
        return ucfirst(UserGenders::getValueById($this->gender));
    }
}
