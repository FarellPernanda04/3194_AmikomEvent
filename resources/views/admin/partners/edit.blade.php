@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">

    <div>

        <h1 class="text-3xl font-black">
            Edit Partner
        </h1>

        <p class="text-slate-500 font-medium">
            Perbarui data partner platform.
        </p>

    </div>

</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">

    <form
        action="/admin/partners/{{ $partner->id }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="block text-sm font-bold text-slate-600 mb-2">
                    Nama Partner
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ $partner->name }}"
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
                    value="{{ $partner->logo_url }}"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                >

            </div>

        </div>

        <div class="mt-8 flex gap-4">

            <button
                type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition"
            >
                Update Partner
            </button>

            <a
                href="/admin/partners"
                class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition"
            >
                Kembali
            </a>

        </div>

    </form>

</div>

@endsection