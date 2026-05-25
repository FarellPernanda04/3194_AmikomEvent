<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->input('q') . '%');
        }

        $partners = $query->latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['required', 'string', 'max:255'],
        ]);

        Partner::create($validated);

        return redirect('/admin/partners')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partners.edit', compact('partner'));
    }


    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['required', 'string', 'max:255'],
        ]);

        $partner->update($validated);

        return redirect('/admin/partners')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        $partner->delete();

        return redirect('/admin/partners')->with('success', 'Partner berhasil dihapus.');
    }
}