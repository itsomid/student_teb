<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;

class RegisterVerificationHistory extends Model
{
    use HasFactory;

    protected $fillable=['student_id', 'admin_id', 'action'];

    public function student() : BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function admin() : BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y H:i');
    }
}
