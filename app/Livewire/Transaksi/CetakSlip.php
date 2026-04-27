<?php

namespace App\Livewire\Transaksi;

use App\Models\Penggajian;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CetakSlip extends Component
{
    #[Layout('components.layouts.print')]
    #[Title('Cetak Slip Transaksi')]
    
    public $penggajian;

    public function mount($id)
    {
        // Ambil data gaji beserta relasi karyawan, departemen, dan jabatan
        $this->penggajian = Penggajian::with(['karyawan.departemen', 'karyawan.jabatan'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.transaksi.cetak-slip');
    }
}