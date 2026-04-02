<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenaltyPayment extends Model
{
    protected $fillable = [
        'return_id',
        'payment_method',
        'amount',
        'payment_date',
        'payment_status',
        'payment_proof',
        'midtrans_order_id',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function return()
    {
        return $this->belongsTo(ReturnKendaraan::class, 'return_id');
    }
}
