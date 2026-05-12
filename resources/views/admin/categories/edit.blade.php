@extends('layouts.admin')

@section('content')
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Edit Kategori</h1>
            <p class="text-slate-500 font-medium">Perbarui nama kategori.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}"
            class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
            Kembali
        </a>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Nama Kategori</label>
                    <input type="text" name="name" value="{{ $category->name }}" placeholder="Contoh: Seminar IT"
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('name')
                        <p class="text-rose-600 text-sm font-bold mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="mt-8 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                Update Kategori
            </button>
        </form>
    </div>
@endsection
