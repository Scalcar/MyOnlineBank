<?php

namespace App\Models;

use App\General\Concretes\Enums\AccountBranches;
use App\General\Concretes\Enums\AccountCurrency;
use App\General\Concretes\Enums\AccountType;
use App\General\Concretes\Enums\PinStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'accNo',
        'branch',
        'type',
        'balance',
        'currency',
        'pin',
        'pinStatus',
        'user_id',
        'admin_id',       
    ];

    protected $hidden = [
        'pin',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function status()
    {
        return $this->hasOne(AccountStatus::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getAccountBranchAttribute()
    {
        return ucfirst(AccountBranches::getValueById($this->branch));
    }

    public function getAccountTypeAttribute()
    {
        return ucfirst(AccountType::getValueById($this->type));
    }

    public function getAccountCurrencyAttribute()
    {
        return AccountCurrency::getValueById($this->currency);
    }

    public function getStatusPinAttribute()
    {
        return ucwords(PinStatus::getValueById($this->pinStatus));
    }

}
