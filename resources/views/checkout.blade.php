@extends('layouts.app')

@section('content')
    <main class="max-w-6xl mx-auto px-6 py-12">
        <section class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] items-start">
            <div class="space-y-6">
                <a href="{{ route('events.show', $event->id) }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                    &larr; Kembali ke Event
                </a>

                <div class="rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
                    <h1 class="text-4xl font-black">Checkout</h1>
                    <p class="mt-3 text-slate-600">Lengkapi data Anda untuk mendapatkan tiket.</p>

                    @if(session('error'))
                        <div class="mt-6 rounded-3xl border border-rose-100 bg-rose-50 px-5 py-4 text-rose-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mt-8 grid gap-6">
                        <div class="rounded-3xl border border-slate-200 p-6 bg-slate-50">
                            <div class="flex flex-col md:flex-row gap-6">
                                <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/200x200' }}"
                                    alt="{{ $event->title }}" class="w-full md:w-48 h-48 rounded-3xl object-cover">

                                <div class="space-y-3">
                                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Event</p>
                                    <h2 class="text-2xl font-bold">{{ $event->title }}</h2>
                                    <p class="text-slate-600">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                                    <p class="text-lg font-black text-indigo-600">1 x Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 p-6 bg-white">
                            <h3 class="text-xl font-semibold mb-4">Rincian Pembayaran</h3>
                            <div class="space-y-3 text-slate-700">
                                <div class="flex justify-between">
                                    <span>Harga Tiket</span>
                                    <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Layanan</span>
                                    <span>Rp 5.000</span>
                                </div>
                                <div class="border-t border-slate-200 pt-4 flex justify-between font-black text-lg text-slate-900">
                                    <span>Total Bayar</span>
                                    <span>Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
                <div class="mb-8">
                    <h2 class="text-3xl font-black">Data Pemesan</h2>
                    <p class="mt-2 text-slate-500">Checkout sebagai tamu tanpa membuat akun.</p>
                </div>

                <form action="{{ route('checkout.store', $event) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            class="w-full rounded-3xl border border-slate-200 px-5 py-4 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('customer_name')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Aktif</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                            class="w-full rounded-3xl border border-slate-200 px-5 py-4 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                            placeholder="contoh@email.com">
                        <p class="mt-2 text-xs text-slate-500">E-Ticket akan dikirim ke email ini.</p>
                        @error('customer_email')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                            class="w-full rounded-3xl border border-slate-200 px-5 py-4 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                            placeholder="0812xxxxxxxx">
                        @error('customer_phone')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-3xl bg-indigo-600 px-6 py-4 text-white font-black uppercase tracking-widest hover:bg-indigo-700 transition">
                        Lanjut Pembayaran
                    </button>

                    <p class="text-xs text-slate-400">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.</p>
                </form>
            </div>
        </section>
    </main>
@endsection