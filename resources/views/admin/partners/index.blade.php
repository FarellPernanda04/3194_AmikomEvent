@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Manajemen Partner</h1>

        <p class="text-slate-500 font-medium">
            Kelola data partner pendukung platform.
        </p>
    </div>
</header>

{{-- FORM TAMBAH PARTNER --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 mb-8">

    <h2 class="text-2xl font-black mb-6">
        Tambah Partner
    </h2>

    <form action="/admin/partners" method="POST">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">
                    Nama Partner
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan nama partner"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                >
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">
                    Logo URL
                </label>

                <input
                    type="text"
                    name="logo_url"
                    placeholder="https://example.com/logo.png"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                >
            </div>

        </div>

        <button
            type="submit"
            class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition"
        >
            + Tambah Partner
        </button>

    </form>

</div>

{{-- TABLE PARTNER --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

    <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">

        <form action="/admin/partners" method="GET" class="flex-1 flex gap-4">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari partner..."
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
            <button
                type="submit"
                class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition"
            >
                Cari
            </button>
        </form>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">

                <tr>

                    <th class="px-8 py-4 w-16">No</th>

                    <th class="px-8 py-4">
                        Logo
                    </th>

                    <th class="px-8 py-4">
                        Nama Partner
                    </th>

                    <th class="px-8 py-4">
                        Dibuat
                    </th>

                    <th class="px-8 py-4">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y border-t">

                @foreach($partners as $partner)

                <tr class="hover:bg-slate-50/50 transition">

                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-8 py-6">

                        <img
                            src="{{ $partner->logo_url }}"
                            class="w-20 h-20 object-cover rounded-2xl border"
                        >

                    </td>

                    <td class="px-8 py-6">

                        <p class="font-black text-slate-800">
                            {{ $partner->name }}
                        </p>

                    </td>

                    <td class="px-8 py-6 text-slate-600">
                        {{ $partner->created_at->format('d M Y') }}
                    </td>

                    <td class="px-8 py-6">

                        <div class="flex gap-2">

                            {{-- EDIT --}}
                            <a
                                href="/admin/partners/{{ $partner->id }}/edit"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                            >

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>

                            </a>

                            {{-- DELETE --}}
                            <form
                                action="/admin/partners/{{ $partner->id }}"
                                method="POST"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                >

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection