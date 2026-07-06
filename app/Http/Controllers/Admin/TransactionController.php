<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $query = Transaction::with('event');

    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $transactions = $query->latest()->paginate(10);

    return view('admin.transactions', compact('transactions'));
}
}
