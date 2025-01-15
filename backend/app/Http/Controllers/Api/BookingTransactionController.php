<?php

namespace App\Http\Controllers\Api;

use Twilio\Rest\Client;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use App\Models\BookingTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ViewBookingResource;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;

class BookingTransactionController extends Controller
{
    public function booking_details(Request $request){
        $request->validate([
            'phone_number' => 'required|string',
            'booking_trx_id' => 'required|string',
        ]);

        $booking = BookingTransaction::where('phone_number', $request->phone_number)->where('booking_trx_id', $request->booking_trx_id)->with(['officeSpace', 'officeSpace.city'])->first();

        if(!$booking){
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return new ViewBookingResource($booking);
    }

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
        // Find your acount SID and Auth Token at Twilio.com/console
        // and set the environment variables. See httpL//twil.io/secure
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token); 

        // Create the message with line breaks
        $messageBody = "Hi {$bookingTransaction->name}, Terima kasih telah booking kantor di FirstOffice.\n\n";
        $messageBody .= "Pesanan kantor {$bookingTransaction->officeSpace->name} Anda sedang kami proses dengan Booking TRX ID: {$bookingTransaction->booking_trx_id}.\n\n";
        $messageBody .= "Kami akan menginformasikan kembali status pemesanan Anda secepat mungkin.";

        // Kirim dengan fitur sms
        $message = $twilio->messages->create(
            "+{$bookingTransaction->phone_number}",
            // "+6289514483012", 
            // to
            [
                "body" => $messageBody,
                "from" => getenv("TWILIO_PHONE_NUMBER"),
            ]
            );

        // mengmbalikan response hasil transaksi
        $bookingTransaction->load('officeSpace');
        return new BookingTransactionResource($bookingTransaction);
    }
}
