<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * CRUD barang temuan.
 * index() dan show() melayani H-02 dan H-03 dari sisi mahasiswa;
 * create/store/edit/update/destroy melayani pengelolaan data oleh petugas.
 */
class ItemController extends Controller
{
    /** H-02 Cari Barang — penyaringan kategori, lokasi, dan rentang tanggal (US-06). */
    public function index(Request $request)
    {
        $query = Item::query()->where('status', 'aktif');

        // AC-06.1 — penyaringan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        // AC-06.2 — lokasi bersifat opsional. Ketika dikosongkan, tidak ada
        // kondisi tambahan yang diterapkan, sehingga jumlah hasil tidak berkurang.
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->string('location') . '%');
        }

        // AC-06.3 — rentang tanggal penemuan
        if ($request->filled('from')) {
            $query->whereDate('found_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('found_at', '<=', $request->date('to'));
        }

        $items = $query->latest('found_at')->get();

        return view('items.index', [
            'items'      => $items,
            'categories' => Item::KATEGORI,
            'filters'    => $request->only(['category', 'location', 'from', 'to']),
        ]);
    }

    /** H-03 Detail Barang. Ciri tersembunyi tidak diteruskan ke view ini (AC-04.2). */
    public function show(Item $item)
    {
        return view('items.show', ['item' => $item]);
    }

    /** Daftar pengelolaan barang untuk petugas. */
    public function manage()
    {
        return view('items.manage', [
            'items' => Item::withCount('claims')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('items.create', ['categories' => Item::KATEGORI]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateItem($request);

        Item::create($this->withDerivedFields($validated));

        return redirect()->route('items.manage')
            ->with('success', 'Barang temuan berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        return view('items.edit', [
            'item'       => $item,
            'categories' => Item::KATEGORI,
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $validated = $this->validateItem($request);

        $item->update($this->withDerivedFields($validated));

        return redirect()->route('items.manage')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.manage')
            ->with('success', 'Data barang berhasil dihapus.');
    }

    /* ---------------------------------------------------------------- */

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'name'           => ['required', 'string', 'max:120'],
            'category'       => ['required', 'string', 'in:' . implode(',', Item::KATEGORI)],
            'location'       => ['required', 'string', 'max:150'],
            'faculty'        => ['required', 'string', 'max:100'],
            'found_at'       => ['required', 'date', 'before_or_equal:today'],
            // AC-04.3 — ciri detail wajib diisi, karena menjadi dasar verifikasi
            'hidden_traits'  => ['required', 'string', 'min:20'],
            'finder_contact' => ['nullable', 'string', 'max:40'],
            'status'         => ['nullable', 'string', 'in:aktif,menunggu_pengambilan,sudah_diserahkan,arsip'],
        ], [
            'found_at.before_or_equal' => 'Waktu penemuan tidak boleh berada di masa depan.',
            'hidden_traits.required'   => 'Ciri detail diperlukan untuk memverifikasi pemilik.',
            'hidden_traits.min'        => 'Tuliskan ciri detail minimal 20 karakter agar dapat diuji.',
        ]);
    }

    /** Jalur dan masa tayang diturunkan dari kategori, bukan diisi manual. */
    private function withDerivedFields(array $validated): array
    {
        $route = Item::routeForCategory($validated['category']);

        $validated['route']          = $route;
        $validated['finder_contact'] = $route === 'penemu' ? ($validated['finder_contact'] ?? null) : null;
        $validated['status']         = $validated['status'] ?? 'aktif';
        $validated['expires_at']     = Carbon::parse($validated['found_at'])
            ->addDays(Item::lifespanForCategory($validated['category']));

        return $validated;
    }
}
