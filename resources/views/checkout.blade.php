@extends('layouts.admin')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        Data Partner
    </h1>

    {{-- FORM TAMBAH PARTNER --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h2 class="text-xl font-semibold mb-4">
            Tambah Partner
        </h2>

        <form action="/admin/partners" method="POST">

            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama Partner
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama partner"
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Logo URL
                </label>

                <input
                    type="text"
                    name="logo_url"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="https://example.com/logo.png"
                >
            </div>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
            >
                Simpan
            </button>

        </form>

    </div>

    {{-- TABEL PARTNER --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <h2 class="text-xl font-semibold mb-4">
            List Partner
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>

                    <tr class="bg-gray-100">

                        <th class="border px-4 py-3 text-left">
                            No
                        </th>

                        <th class="border px-4 py-3 text-left">
                            Logo
                        </th>

                        <th class="border px-4 py-3 text-left">
                            Nama Partner
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($partners as $partner)

                    <tr class="hover:bg-gray-50">

                        <td class="border px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-4 py-3">

                            <img
                                src="{{ $partner->logo_url }}"
                                class="w-20 h-20 object-cover rounded-lg"
                            >

                        </td>

                        <td class="border px-4 py-3">
                            {{ $partner->name }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection