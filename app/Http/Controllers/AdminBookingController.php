<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alat;
use App\Models\Booking;
use App\Models\User;

// CRUD data peminjaman untuk ADMIN.
// Admin TIDAK menyetujui / menolak. Itu hanya tugas petugas.
class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        $bookings = Booking::with(['user', 'detail.alat'])
            ->when(in_array($status, ['pending', 'approved', 'rejected', 'completed']),
                fn ($x) => $x->where('status', $status))
            ->orderBy('id', 'desc')
            ->simplePaginate(15)
            ->withQueryString();

        return view('admin.booking.index', compact('bookings', 'status'));
    }

    public function create()
    {
        return view('admin.booking.create', $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($error = $this->cekStok($data['items'])) {
            return back()->withInput()->with('error', $error);
        }

        DB::transaction(function () use ($data) {
            $booking = Booking::create([
                'user_id'         => $data['user_id'],
                'tanggal_mulai'   => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'status'          => 'pending',   // selalu menunggu verifikasi petugas
            ]);

            foreach ($data['items'] as $item) {
                $booking->detail()->create($item);
            }
        });

        return redirect()->route('admin.booking.index')
            ->with('success', 'Data peminjaman ditambahkan. Statusnya menunggu verifikasi petugas.');
    }

    public function edit(Booking $booking)
    {
        $booking->load(['user', 'detail.alat']);

        return view('admin.booking.edit', $this->pilihan() + compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Sudah diproses petugas: hanya tanggal yang boleh diubah,
        // supaya stok dan riwayat tidak kacau.
        if ($booking->status !== 'pending') {
            $data = $request->validate([
                'tanggal_mulai'   => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ]);

            $booking->update($data);

            return redirect()->route('admin.booking.index')
                ->with('success', 'Tanggal peminjaman diperbarui.');
        }

        $data = $request->validate($this->rules());

        if ($error = $this->cekStok($data['items'])) {
            return back()->withInput()->with('error', $error);
        }

        DB::transaction(function () use ($data, $booking) {
            $booking->update([
                'user_id'         => $data['user_id'],
                'tanggal_mulai'   => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
            ]);

            $booking->detail()->delete();

            foreach ($data['items'] as $item) {
                $booking->detail()->create($item);
            }
        });

        return redirect()->route('admin.booking.index')
            ->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        DB::transaction(function () use ($booking) {
            $booking->load('detail');

            // Alat sedang keluar (stok sudah dikurangi): kembalikan stoknya
            if ($booking->status === 'approved') {
                foreach ($booking->detail as $d) {
                    Alat::where('id', $d->alat_id)->increment('jumlah', $d->jumlah);
                }
            }

            $booking->pengembalian()->delete();
            $booking->detail()->delete();
            $booking->delete();
        });

        return redirect()->route('admin.booking.index')
            ->with('success', 'Data peminjaman dihapus.');
    }

    // ---------- bantuan ----------

    private function pilihan(): array
    {
        return [
            'users' => User::where('role', 'user')->orderBy('username')->get(),   // ganti 'nama' kalau kolom di tabel user berbeda
            'alats' => Alat::orderBy('nama_alat')->get(),
        ];
    }

    private function rules(): array
    {
        return [
            'user_id'           => 'required|exists:user,id',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'items'             => 'required|array|min:1',
            'items.*.alat_id'   => 'required|distinct|exists:alat,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ];
    }

    private function cekStok(array $items): ?string
    {
        foreach ($items as $item) {
            $alat = Alat::find($item['alat_id']);

            if ($alat->jumlah < $item['jumlah']) {
                return 'Stok ' . $alat->nama_alat . ' hanya tersisa ' . $alat->jumlah . ' unit.';
            }
        }

        return null;
    }
}