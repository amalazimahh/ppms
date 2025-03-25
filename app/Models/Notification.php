<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = ['user_id', 'type', 'message', 'read'];

    public function recipient()
    {
        return $this->hasMany(NotificationRecipient::class);
    }
}
