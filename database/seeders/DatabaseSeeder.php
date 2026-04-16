<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
        ]);

        // === 2. BUAT DEPARTEMEN ===
        $sIt = Departemen::create(['nama' => 'Teknologi Informasi', 'kode' => 'IT']);
        $sHrd = Departemen::create(['nama' => 'Human Resources', 'kode' => 'HRD']);
        $sFin = Departemen::create(['nama' => 'Keuangan', 'kode' => 'FIN']);
        $sOps = Departemen::create(['nama' => 'Operasional', 'kode' => 'OPS']);

        // === 3. BUAT JABATAN ===
        $sProgr = Jabatan::create(['departemen_id' => $sIt->id, 'nama' => 'Programmer', 'gaji_pokok' => 8_000_000]);
        $sAnalyst = Jabatan::create(['departemen_id' => $sIt->id, 'nama' => 'System Analyst', 'gaji_pokok' => 10_000_000]);
        $sHrdStaff = Jabatan::create(['departemen_id' => $sHrd->id, 'nama' => 'Staff HRD', 'gaji_pokok' => 6_000_000]);
        $sHrdMgr = Jabatan::create(['departemen_id' => $sHrd->id, 'nama' => 'Manajer HRD', 'gaji_pokok' => 12_000_000]);
        $sAkuntan = Jabatan::create(['departemen_id' => $sFin->id, 'nama' => 'Akuntan', 'gaji_pokok' => 7_000_000]);
        $sKasir = Jabatan::create(['departemen_id' => $sFin->id, 'nama' => 'Kasir', 'gaji_pokok' => 5_000_000]);
        $sSopir = Jabatan::create(['departemen_id' => $sOps->id, 'nama' => 'Sopir', 'gaji_pokok' => 4_000_000]);
        $sGudang = Jabatan::create(['departemen_id' => $sOps->id, 'nama' => 'Staff Gudang', 'gaji_pokok' => 4_000_000]);

        // === 2. BUAT DEPARTEMEN ===
        $it  = Departemen::create(['nama' => 'Teknologi Informasi', 'kode' => 'IT']);
        $hrd = Departemen::create(['nama' => 'Human Resources', 'kode' => 'HRD']);
        $fin = Departemen::create(['nama' => 'Keuangan', 'kode' => 'FIN']);
        $ops = Departemen::create(['nama' => 'Operasional', 'kode' => 'OPS']);

        // === 3. BUAT JABATAN ===
        $progr   = Jabatan::create(['departemen_id' => $it->id, 'nama' => 'Programmer', 'gaji_pokok' => 8_000_000]);
        $analyst = Jabatan::create(['departemen_id' => $it->id, 'nama' => 'System Analyst', 'gaji_pokok' => 10_000_000]);

        $hrdstaf = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'Staff HRD', 'gaji_pokok' => 6_000_000]);
        $hrdgr   = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'Manajer HRD', 'gaji_pokok' => 12_000_000]);

        $akuntan = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Akuntan', 'gaji_pokok' => 7_000_000]);
        $kasir   = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Kasir', 'gaji_pokok' => 5_000_000]);

        $sopir   = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Sopir', 'gaji_pokok' => 4_000_000]);
        $gudang  = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Staff Gudang', 'gaji_pokok' => 4_000_000]);

        // === 4. BUAT DATA KARYAWAN ===
        $karyawan = [
            ['nik' => 'KRY-001', 'nama' => 'Andi Pratama', 'email' => 'andi@perusahaan.com', 'dept' => $it,  'jabatan' => $progr,   'gaji' => 8_000_000,  'tunj' => 500_000],
            ['nik' => 'KRY-002', 'nama' => 'Siti Rahayu',  'email' => 'siti@perusahaan.com', 'dept' => $it,  'jabatan' => $analyst, 'gaji' => 10_000_000, 'tunj' => 750_000],
            ['nik' => 'KRY-003', 'nama' => 'Budi Santoso', 'email' => 'budi@perusahaan.com', 'dept' => $hrd, 'jabatan' => $hrdgr,   'gaji' => 12_000_000, 'tunj' => 1_000_000],
            ['nik' => 'KRY-004', 'nama' => 'Dewi Kusuma',  'email' => 'dewi@perusahaan.com', 'dept' => $hrd, 'jabatan' => $hrdstaf, 'gaji' => 6_000_000,  'tunj' => 400_000],
            ['nik' => 'KRY-005', 'nama' => 'Ahmad Fauzi',  'email' => 'ahmad@perusahaan.com', 'dept' => $fin, 'jabatan' => $akuntan, 'gaji' => 7_000_000,  'tunj' => 500_000],
            ['nik' => 'KRY-006', 'nama' => 'Rina Permata', 'email' => 'rina@perusahaan.com', 'dept' => $fin, 'jabatan' => $kasir,   'gaji' => 5_000_000,  'tunj' => 300_000],
            ['nik' => 'KRY-007', 'nama' => 'Joko Widodo',  'email' => 'joko@perusahaan.com', 'dept' => $ops, 'jabatan' => $sopir,   'gaji' => 4_500_000,  'tunj' => 200_000],
            ['nik' => 'KRY-008', 'nama' => 'Lina Permata', 'email' => 'lina@perusahaan.com', 'dept' => $ops, 'jabatan' => $gudang,  'gaji' => 4_000_000,  'tunj' => 200_000],
        ];

        foreach ($karyawan as $data) {
            Karyawan::create([
                'nik'            => $data['nik'],
                'nama'           => $data['nama'],
                'email'          => $data['email'],
                'telepon'        => rand(100_000_000, 999_999_999),
                'jenis_kelamin'  => rand(1, 2), // 1 = laki-laki, 2 = perempuan
                'tanggal_masuk'  => now()->subMonths(rand(6, 36))->toDateString(),
                'departemen_id'  => $data['dept']->id,
                'jabatan_id'     => $data['jabatan']->id,
                'gaji_pokok'     => $data['gaji'],
                'tunjangan'      => $data['tunj'],
                'status'         => 'aktif',
                'bank'           => ['BCA', 'Mandiri', 'BNI', 'BRI'][rand(0, 3)],
                'no_rekening'    => '1234' . rand(100_000_000, 999_999_999),
            ]);
        }
    }
}
