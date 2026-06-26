@extends('layouts.app')

@section('content')
    <main class="max-w-5xl mx-auto px-6 py-16">
        <div class="rounded-[2rem] bg-white border border-slate-200 p-10 shadow-xl">
            <div class="flex flex-col gap-6 lg:flex-row lg:justify-between lg:items-center mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-emerald-600 font-bold">Pembayaran Berhasil</p>
                    <h1 class="text-4xl font-black mt-4">Terima kasih, {{ $transaction->customer_name }}!</h1>
                    <p class="mt-3 text-slate-600">Pesanan Anda telah diterima dan tiket akan segera diproses. Simpan bukti berikut untuk referensi.</p>
                </div>
                <div class="rounded-3xl bg-emerald-50 px-6 py-5 text-emerald-800 font-semibold uppercase tracking-[0.2em] text-sm">
                    {{ $transaction->order_id }}
                </div>
            </div>

            <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-8">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 p-6 bg-slate-50">
                            <p class="text-sm text-slate-500 uppercase tracking-[0.2em] font-semibold">Nama Pemesan</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">{{ $transaction->customer_name }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 p-6 bg-slate-50">
                            <p class="text-sm text-slate-500 uppercase tracking-[0.2em] font-semibold">No. WhatsApp</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">{{ $transaction->customer_phone }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 p-6 bg-slate-50">
                            <p class="text-sm text-slate-500 uppercase tracking-[0.2em] font-semibold">Email</p>
                            <p class="mt-3 text-xl font-bold text-slate-900 break-words">{{ $transaction->customer_email }}</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 p-6 bg-slate-50">
                            <p class="text-sm text-slate-500 uppercase tracking-[0.2em] font-semibold">Total Bayar</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-8">
                        <h2 class="text-2xl font-bold mb-4">Detail Event</h2>
                        <div class="space-y-3 text-slate-700">
                            <p class="font-semibold">{{ $event->title }}</p>
                            <p>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</p>
                            <p>{{ $event->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="rounded-[2rem] border border-slate-200 p-8 text-center">
                        <div class="inline-flex items-center justify-center w-32 h-32 mx-auto rounded-3xl bg-slate-100 mb-6">
                            <svg class="w-20 h-20 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16v16H4z" />
                                <path d="M7 9h2v6H7zM11 9h2v6h-2zM15 9h2v6h-2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black">QRIS Pembayaran</h3>
                        <p class="mt-3 text-slate-500">Scan QR berikut untuk menyelesaikan konfirmasi pembayaran.</p>
                        <div class="mt-8 inline-block rounded-3xl bg-white p-6 shadow-lg">
                            <div class="w-64 h-64 bg-slate-100 rounded-3xl flex items-center justify-center">
                                <div class="grid grid-cols-3 gap-2">
                                    @for($i = 0; $i < 9; $i++)
                                        <div class="w-8 h-8 rounded-sm bg-slate-700"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                        <h3 class="text-xl font-bold mb-3">Instruksi</h3>
                        <ol class="list-decimal list-inside space-y-3 text-slate-600">
                            <li>Pastikan Anda sudah menyimpan Order ID.</li>
                            <li>Scan barcode QRIS di atas atau gunakan aplikasi pembayaran.</li>
                            <li>Simpan bukti pembayaran untuk cek masuk acara.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection