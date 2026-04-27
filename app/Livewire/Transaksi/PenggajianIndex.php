<?php

namespace App\Livewire\Transaksi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Penggajian;

class PenggajianIndex extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;
    public $search = '';

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y'); // gunakan 'Y' agar tahun 4 digit
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset page jika user mengganti bulan/tahun (filter)
    public function updateBulan()
    {
        $this->resetPage();
    }
    public function updateTahun()
    {
        $this->resetPage();
    }

    public function render()
    {
        $penggajians = Penggajian::with(['karyawan.departemen', 'karyawan.jabatan'])
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->whereHas('karyawan', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('livewire.transaksi.penggajian-index', compact('penggajians'));
    }

    // Fungsi untuk membuka detail penggajian
    public function generatePayroll()
    {
        // 1. Cek apakah sudah ada penggajian untuk bulan/tahun ini
        $sudahAda = Penggajian::where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->exists();

        if ($sudahAda) {
            session()->flash(
                'error',
                'Penggajian untuk bulan ' . $this->bulan . ' tahun ' . $this->tahun . ' sudah pernah di proses.'
            );
            return;
        }

        // 2. Ambil semua karyawan aktif
        $karyawans = Karyawan::where('status', 'aktif')->get();
        if ($karyawans->isEmpty()) {
            session()->flash('error', 'Gagal! Tidak ada karyawan aktif untuk digaji.');
            return;
        }

        // 3. Proses penggajian untuk setiap karyawan (looping/massal)
        $count = 0;
        foreach ($karyawans as $karyawan) {
            $potongan = $karyawan->gaji_pokok * 0.03;
            $total_gaji = ($karyawan->gaji_pokok + $karyawan->tunjangan) - $potongan;

            Penggajian::create([
                'karyawan_id' => $karyawan->id,
                'bulan'       => $this->bulan,
                'tahun'       => $this->tahun,
                'tanggal_proses' => date('y-m-d'),
                'gaji_pokok'  => $karyawan->gaji_pokok,
                'tunjangan'   => $karyawan->tunjangan,
                'potongan'    => $potongan,
                'total_gaji'  => $total_gaji,
            ]);

            $count++;
        }
        session()->flash('succes', 'berhasil gaji untuk periode' . $this->bulan . '/' . $this->tahun . 'telah diproses. Total karyawan yang di-gaji:' . $count);
    }

    public function delete($id)
    {
        Penggajian::findOrFail($id)->delete();
        session()->flash('message', 'Data penggajian berhasil dihapus.');
    }
}
