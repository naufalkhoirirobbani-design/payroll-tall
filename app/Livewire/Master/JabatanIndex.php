<?php

namespace App\Livewire\Master;

use Livewire\Attribute\Layout;
use Livewire\Attribute\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Jabatan;
use App\Models\Departemen;

#[Layout('components.layout.app')]
#[Title('Manajemen Jabatan')]
class JabatanIndex extends Component
{
    use WithPagination;

    // properti Form
    public $jabatan_id, $departemen_id, $nama, $gaji_pokok;

    // properti UI
    public $isOpen = false;
    public $search = '';

    public function render()
    {
        // Query dengan relasi departemen
        $jabatan = Jabatan::with('departemen')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('departemen', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Mengambil nama departemen untuk dropdown
        $departemens = Departemen::orderBy('nama', 'asc')->get();

        return view('livewire.master.jabatan-index', [
            'jabatan' => $jabatan,
            'departemens' => $departemens,
        ]);
    }

    // membuka modal
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->jabatan_id = null;
        $this->departemen_id = null;
        $this->nama = '';
        $this->gaji_pokok = '';
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate([
            'departemen_id' => 'required|exists:departemen,id',
            'nama' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0'
        ]);

        Jabatan::updateOrCreate(
            ['id' => $this->jabatan_id],
            [
                'departemen_id' => $this->departemen_id,
                'nama' => $this->nama,
                'gaji_pokok' => $this->gaji_pokok
            ]
        );

        session()->flash('message', $this->jabatan_id ? 'Jabatan berhasil diperbarui.' : 'Jabatan berhasil dibuat.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $this->jabatan_id = $id;
        $this->departemen_id = $jabatan->departemen_id;
        $this->nama = $jabatan->nama;
        $this->gaji_pokok = $jabatan->gaji_pokok;

        $this->openModal();
    }

    public function delete($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();
            session()->flash("message", "Jabatan berhasil dihapus.");
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // kode error untuk integrity constraint violation
                session()->flash("error", "Gagal! Jabatan masih digunakan oleh data lain.");
            } else {
                session()->flash("error", "Terjadi kesalahan saat menghapus jabatan.");
            }
        }
    }
}
