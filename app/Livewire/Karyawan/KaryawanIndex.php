<?php

namespace App\Livewire\Karyawan;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Karyawan; // pastikan model Karyawan di-import

#[Layout('components.layouts.app')]
#[Title('Data karyawan')]
class KaryawanIndex extends Component
{
    use WithPagination;

    public $search = '';

    // Properti untuk detail
    public $isDetailModalOpen = false;
    public $karyawanDetail;

    public function updatingSearch()
    {
        $this->resetPage(); // harus pakai tanda kurung
    }

    public function render()
    {
        $karyawan = Karyawan::with(['departemen', 'jabatan'])
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('nik', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.karyawan.karyawan-index', [
            'karyawan' => $karyawan,
        ]);
    }

    public function showDetail($id)
    {
        // Ambil data karyawan dan relasi
        $this->karyawanDetail = Karyawan::with(['departemen', 'jabatan'])->findOrFail($id);
        $this->isDetailModalOpen = true;
    }

    public function closeNotFinish()
    {
        session()->flash('info', 'Fitur ini belum selesai.');
    }
}
