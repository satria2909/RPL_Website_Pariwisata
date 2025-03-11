<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Payment; // Model untuk menyimpan status pembayaran

class PaymentController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        // Mempersiapkan data transaksi
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->input('amount'),
            ],
            'customer_details' => [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ],
        ];

        try {
            // Membuat Snap token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan informasi pembayaran ke database (misal menggunakan model Payment)
            $payment = Payment::create([
                'order_id' => $params['transaction_details']['order_id'],
                'name' => $params['customer_details']['name'],
                'email' => $params['customer_details']['email'],
                'phone' => $params['customer_details']['phone'],
                'amount' => $params['transaction_details']['gross_amount'],
                'status' => 'Unpaid', // Status awal adalah pending
            ]);

            // Kembalikan snap token sebagai respons
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
{
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

    // Verifikasi signature_key
    if ($hashed === $request->signature_key) {
        // Ambil data pembayaran berdasarkan order_id
        $payment = Payment::where('order_id', $request->order_id)->first();

        if ($payment) {
            // Update status pembayaran berdasarkan status transaksi Midtrans
            switch ($request->transaction_status) {
                case 'capture':
                    // Jika pembayaran menggunakan kartu kredit
                    if ($request->payment_type === 'credit_card') {
                        $payment->update(['status' => 'Paid']);
                    }
                    break;

                case 'settlement':
                    // Pembayaran berhasil untuk metode selain kartu kredit
                    $payment->update(['status' => 'Paid']);
                    break;

                case 'pending':
                    // Pembayaran sedang menunggu
                    $payment->update(['status' => 'Pending']);
                    break;

                case 'deny':
                    // Pembayaran ditolak
                    $payment->update(['status' => 'Denied']);
                    break;

                case 'expire':
                    // Pembayaran kadaluarsa
                    $payment->update(['status' => 'Expired']);
                    break;

                case 'cancel':
                    // Pembayaran dibatalkan
                    $payment->update(['status' => 'Cancelled']);
                    break;

                default:
                    // Status tidak dikenal
                    $payment->update(['status' => 'Unknown']);
                    break;
            }
        }
    } else {
        // Signature tidak valid
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    return response()->json(['message' => 'Callback handled successfully'], 200);
}

}