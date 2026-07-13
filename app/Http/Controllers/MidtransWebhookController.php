<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $transaction = Transaction::with('event')
            ->where('order_id', $orderId)
            ->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses berulang jika status sudah lunas/sukses
        if (in_array($transaction->status, ['settlement', 'success'], true)) {
            return response()->json(['message' => 'Already processed']);
        }

        // Logika Penerjemahan Status Midtrans API
        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $transaction->status = 'challenge';
            } elseif ($fraudStatus === 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus === 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'], true)) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        return response()->json(['message' => 'OK']);
    }

    private function processSuccess(Transaction $transaction)
    {
        // Placeholder untuk Modul 13 (misalnya pemotongan tiket / update entitas lain)
    }
}

