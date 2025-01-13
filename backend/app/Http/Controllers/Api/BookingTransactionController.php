<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    public function store(StoreBookingTransactionRequest $request)
    {
        $validateData = $request->validated();
        $officeSpace = OfficeSpace::find($validateData['office_space_id']);

        $validateData['is_paid']= false;
        $validateData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();
        $validateData['duration'] = $officeSpace->duration;

        $validateData['ended_at'] = (new \DateTime($validateData['started_at']))->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction = BookingTransaction::create($validateData);

        // mengirim notif melalui sms atau wa dengan twilio

        // mengmbalikan response hasil transaksi
        $bookingTransaction->load('officeSpace');
        return new BookingTransactionResource($bookingTransaction);
    }
}
