<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'subject', 'group', 'department', 'from', 'body', 'status', 'shamsi_c',
        'to', 'admin_id', 'attachment', 'type', 'pointer', 'for'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function admin2()
    {
        return $this->belongsTo(Admin::class, 'for');
    }
}
