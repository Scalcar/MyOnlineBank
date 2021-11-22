<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trans_no',
        'description',
        'credit',
        'debit',
        'balance',
        'account_id',
        'contact_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->updated_at)->timezone('Europe/Bucharest')->format('d/m/Y H:i:s');
    }
}
