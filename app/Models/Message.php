<?php

namespace App\Models;

use App\Observers\MessageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


#[ObservedBy(MessageObserver::class)]
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'chat_id',
        'user_login',
        'updated_at'
    ];

    protected $dateFormat = 'Y/m/d H:i:s';


    public function chat() : BelongsTo {
        return $this->belongsTo(Chat::class);
    }
    

    public function user() : HasOne {
        return $this->hasOne(User::class, 'login', 'user_login');
    }
}
