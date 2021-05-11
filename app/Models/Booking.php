<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_CANCELED  = 'CANCELED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'doctor_id',
        'user_id',
        'date',
        'status',
    ];

    public static $allowedFilters = [
        'status',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
    }
}
