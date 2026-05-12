@extends('layouts.admin')

@section('content')
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Tambah Partner</h1>
            <p class="text-slate-500 font-medium">Masukkan data partner pendukung platform.</p>
        </div>

        <a href="/admin/partners"
            class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
            Kembali
        </a>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="/admin/partners" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">
                        Nama Partner
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama partner"
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('name')
                        <p class="text-rose-600 text-sm font-bold mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">
                        Logo URL
                    </label>
                    <input type="text" name="logo_url" value="{{ old('logo_url') }}"
                        placeholder="https://placehold.co/200x200"
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('logo_url')
                        <p class="text-rose-600 text-sm font-bold mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <button type="submit"
                class="mt-8 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                + Simpan Partner
            </button>
        </form>
    </div>
@endsection
