<?php

namespace App\Models;

use App\General\Concretes\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'body',
        'sent_to_id',
        'sender_id',
        'admin_id',
        'admin_sender_id',
        'sender_status',
        'receiver_status',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'sent_to_id');
    }

    public function adminSender()
    {
        return $this->belongsTo(Admin::class,'admin_sender_id');
    }

    public function adminReceiver()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function getStatusNameAttribute()
    {
        return ucfirst(MessageStatus::getValueById($this->status));
    }
}
