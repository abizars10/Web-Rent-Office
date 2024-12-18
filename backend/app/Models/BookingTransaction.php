<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx_id',
        'is_paid',
        'started_at',
        'total_amount',
        'duration',
        'ended_at',
        'office_space_id',
    ];

    // Membuat fungsi generate id otomatis untuk booking_trx_id di booking transaction
    public static function generateUniqueTrxId()
    {
        $prefix = 'RO';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function officeSpace(): BelongsTo
    {
        return $this->belongsTo(OfficeSpace::class);
    }
}
