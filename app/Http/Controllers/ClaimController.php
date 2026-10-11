<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;

/**
 * CRUD pengajuan klaim dari sisi mahasiswa.
 * Memuat aturan bisnis yang mencegah klaim ganda (AC-07.2).
 */
class ClaimController extends Controller
{
    /** H-05 Klaim Saya. */
    public function index()
    {
        return view('claims.index', [
            'claims' => Claim::with('item')->latest()->get(),
        ]);
    }

    /** H-04 Form Klaim. */
    public function create(Request $request)
    {
        $item = Item::findOrFail($request->integer('item'));

        // Barang jalur penemu tidak melewati posko, sehingga tidak dapat diklaim (AC-03.4)
        if (! $item->isClaimable()) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Barang ini tidak dapat diklaim melalui posko.');
        }

        return view('claims.create', ['item' => $item]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'               => ['required', 'exists:items,id'],
            'claimant_name'         => ['required', 'string', 'max:100'],
            'ownership_description' => ['required', 'string', 'min:25'],
        ], [
            'claimant_name.required'         => 'Nama pengklaim wajib diisi.',
            'ownership_description.required' => 'Deskripsi kepemilikan wajib diisi.',
            'ownership_description.min'      => 'Tuliskan minimal 25 karakter. '
                . 'Ciri yang terlalu singkat tidak dapat dibandingkan petugas.',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        // Aturan bisnis 1 — hanya barang jalur posko berstatus aktif yang dapat diklaim
        if (! $item->isClaimable()) {
            return back()->withInput()->withErrors([
                'item_id' => 'Barang ini tidak lagi tersedia untuk diklaim.',
            ]);
        }

        // Aturan bisnis 2 — satu pengklaim tidak boleh memiliki dua klaim berjalan
        // atas barang yang sama (AC-07.2)
        $runningClaim = Claim::where('claimant_name', $validated['claimant_name'])
            ->where('status', 'menunggu')
            ->with('item')
            ->first();

        if ($runningClaim) {
            return back()->withInput()->withErrors([
                'claimant_name' => 'Anda masih memiliki klaim berjalan atas '
                    . $runningClaim->item->name
                    . '. Tunggu keputusan petugas sebelum mengajukan klaim lain.',
            ]);
        }

        $validated['status'] = 'menunggu';
        Claim::create($validated);

        return redirect()->route('claims.index')
            ->with('success', 'Klaim berhasil dikirim dan menunggu verifikasi petugas.');
    }

    public function edit(Claim $claim)
    {
        if (! $claim->isPending()) {
            return redirect()->route('claims.index')
                ->with('error', 'Klaim yang sudah diputuskan tidak dapat diubah.');
        }

        return view('claims.edit', ['claim' => $claim]);
    }

    public function update(Request $request, Claim $claim)
    {
        if (! $claim->isPending()) {
            return redirect()->route('claims.index')
                ->with('error', 'Klaim yang sudah diputuskan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'claimant_name'         => ['required', 'string', 'max:100'],
            'ownership_description' => ['required', 'string', 'min:25'],
        ]);

        $claim->update($validated);

        return redirect()->route('claims.index')
            ->with('success', 'Klaim berhasil diperbarui.');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();

        return redirect()->route('claims.index')
            ->with('success', 'Klaim berhasil dibatalkan.');
    }
}
