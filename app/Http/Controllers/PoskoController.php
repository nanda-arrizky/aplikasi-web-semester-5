<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

/**
 * Antarmuka petugas posko.
 * H-06 daftar klaim, H-07 detail klaim dan pengambilan keputusan.
 */
class PoskoController extends Controller
{
    /**
     * Fakultas petugas. Autentikasi belum masuk lingkup, sehingga nilai ini
     * disimulasikan untuk memperagakan pembatasan akses lintas fakultas (AC-08.3).
     */
    private const FAKULTAS_PETUGAS = 'Fakultas Teknik';
    private const NAMA_PETUGAS     = 'Arif Setiawan';

    /** H-06 Daftar Klaim Posko — terurut dari yang paling lama menunggu (AC-08.1). */
    public function index(Request $request)
    {
        $query = Claim::with('item')
            // AC-08.3 — klaim atas barang fakultas lain tidak ditampilkan
            ->whereHas('item', fn ($q) => $q->where('faculty', self::FAKULTAS_PETUGAS));

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        } else {
            $query->where('status', 'menunggu');
        }

        return view('posko.index', [
            'claims'  => $query->oldest()->get(),
            'current' => $request->string('status')->toString(),
            'faculty' => self::FAKULTAS_PETUGAS,
        ]);
    }

    /** H-07 Detail Klaim — ciri tersembunyi dan deskripsi pengklaim bersisian (AC-08.2). */
    public function show(Claim $claim)
    {
        abort_unless($claim->item->faculty === self::FAKULTAS_PETUGAS, 404);

        return view('posko.show', ['claim' => $claim]);
    }

    /** Menyetujui klaim (AC-09.1). */
    public function approve(Claim $claim)
    {
        abort_unless($claim->item->faculty === self::FAKULTAS_PETUGAS, 404);

        if (! $claim->isPending()) {
            return back()->with('error', 'Klaim ini sudah diputuskan sebelumnya.');
        }

        $claim->update([
            'status'     => 'disetujui',
            'decided_by' => self::NAMA_PETUGAS,
            'decided_at' => now(),
        ]);

        // Barang berpindah status, dan klaim lain atas barang yang sama
        // ditolak otomatis agar tidak ada dua pemilik yang menunggu.
        $claim->item->update(['status' => 'menunggu_pengambilan']);

        Claim::where('item_id', $claim->item_id)
            ->where('id', '!=', $claim->id)
            ->where('status', 'menunggu')
            ->update([
                'status'          => 'ditolak_otomatis',
                'decision_reason' => 'Barang telah diserahkan kepada pengklaim lain '
                    . 'yang terverifikasi lebih dahulu.',
                'decided_by'      => self::NAMA_PETUGAS,
                'decided_at'      => now(),
            ]);

        return redirect()->route('posko.index')
            ->with('success', 'Klaim disetujui. Barang berstatus menunggu pengambilan.');
    }

    /** Menolak klaim. Alasan wajib diisi (AC-09.2). */
    public function reject(Request $request, Claim $claim)
    {
        abort_unless($claim->item->faculty === self::FAKULTAS_PETUGAS, 404);

        if (! $claim->isPending()) {
            return back()->with('error', 'Klaim ini sudah diputuskan sebelumnya.');
        }

        $validated = $request->validate([
            'decision_reason' => ['required', 'string', 'min:10'],
        ], [
            'decision_reason.required' => 'Alasan penolakan wajib diisi.',
            'decision_reason.min'      => 'Tuliskan alasan yang dapat dipertanggungjawabkan, minimal 10 karakter.',
        ]);

        $claim->update([
            'status'          => 'ditolak',
            'decision_reason' => $validated['decision_reason'],
            'decided_by'      => self::NAMA_PETUGAS,
            'decided_at'      => now(),
        ]);

        return redirect()->route('posko.index')
            ->with('success', 'Klaim ditolak beserta alasannya.');
    }

    /** Menandai barang sudah diserahkan kepada pemiliknya. */
    public function handover(Claim $claim)
    {
        abort_unless($claim->item->faculty === self::FAKULTAS_PETUGAS, 404);

        if ($claim->status !== 'disetujui') {
            return back()->with('error', 'Barang hanya dapat diserahkan setelah klaim disetujui.');
        }

        $claim->item->update(['status' => 'sudah_diserahkan']);

        return redirect()->route('posko.index')
            ->with('success', 'Barang ditandai sudah diserahkan.');
    }
}
