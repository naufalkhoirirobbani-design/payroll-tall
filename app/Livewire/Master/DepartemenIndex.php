<?php

namespace App\Livewire\Master;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Departemen;

#[Layout('components.layout.app')]
#[Title('Manajemen Departemen')]
class DepartemenIndex extends Component
{
    use WithPagination;

    // Properti Form
    public $departemen_id, $kode, $nama;

    // Properti UI
    public $isOpen = false;
    public $search = '';

    // Reset pagination ketika melakukan search
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $departemens = Departemen::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('kode', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.departemen-index', compact('departemens'));
        
    }

    // membuka modal
    public function openModal()
    {
        $this->isOpen = true;
    }

    // menutup modal
    public function closeModal()
    {
        $this->isOpen = false;
    }

    // reset form
    public function resetInputFields()
    {
        $this->departemen_id = null;
        $this->kode = '';
        $this->nama = '';
    }

    // membuka modal untuk create
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    // create dan update data
    public function store()
    {
        $this->validate([
            'kode' => 'required|unique:departemen,kode,' . $this->departemen_id,
            'nama' => 'required|string|max:225'
        ]);

        Departemen::updateOrCreate(
            ['id' => $this->departemen_id],
            [
                'kode' => strtoupper($this->kode), // kapital
                'nama' => $this->nama
            ]
        );

        session()->flash('message', $this->departemen_id ? 'Data Departemen berhasil diperbarui.' : 'Data Departemen berhasil dibuat.');

        $this->closeModal();
        $this->resetInputFields();
    }

    // membuka modal untuk edit
    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        $this->departemen_id = $id;
        $this->kode = $departemen->kode;
        $this->nama = $departemen->nama;

        $this->openModal();
    }

    // menghapus data
    public function delete($id)
    {
        $departemen = Departemen::withCount('jabatan')->findOrFail($id);

        if ($departemen->jabatan_count > 0) {
            session()->flash('error', 'Gagal! Departemen masih digunakan oleh data Jabatan.');
            return;
        }

        $departemen->delete();
        session()->flash('message', 'Data Departemen berhasil dihapus.');
    }
}
