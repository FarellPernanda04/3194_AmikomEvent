<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller

{
    public function index()
    {
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        // Pakai whereDate agar tidak terganggu perbedaan jam/timezone pada field date
        // Tampilkan jumlah seluruh event (agar event yang baru dibuat langsung terlihat di dashboard)
        $activeEvents = Event::count();



        // 4. Menghitung Transaksi Ngadat (Status belum dibayar)
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions'
        ));
    }
}

