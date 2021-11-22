<?php

namespace App\Models;

use App\General\Concretes\Enums\AccountStatuses;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'status',
        'activated_at',
        'expires'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'activated_at',
        'expires'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getStatusNameAttribute()
    {
        return ucfirst(AccountStatuses::getValueById($this->status));
    }

    public function getCloseExpiresAttribute()
    {       
        return Carbon::parse($this->expires);
    }
}
