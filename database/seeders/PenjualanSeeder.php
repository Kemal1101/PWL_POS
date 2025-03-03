<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'pembeli' => 'Renald Agustinus',
                'penjualan_kode' => 'PJ001',
                'penjualan_tanggal' => '2024-02-01',
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Septian Tito',
                'penjualan_kode' => 'PJ002',
                'penjualan_tanggal' => '2024-02-02',
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Muhammad Rosyid',
                'penjualan_kode' => 'PJ003',
                'penjualan_tanggal' => '2024-02-03',
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Muhammad Rosyid',
                'penjualan_kode' => 'PJ004',
                'penjualan_tanggal' => '2024-02-04',
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Muhammad Satria Rahmat',
                'penjualan_kode' => 'PJ005',
                'penjualan_tanggal' => '2024-02-05',
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Paudra Akbar Buana',
                'penjualan_kode' => 'PJ006',
                'penjualan_tanggal' => '2024-02-06',
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Jaden Natha',
                'penjualan_kode' => 'PJ007',
                'penjualan_tanggal' => '2024-02-07',
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Abhinaya',
                'penjualan_kode' => 'PJ008',
                'penjualan_tanggal' => '2024-02-08',
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Bagas Satria',
                'penjualan_kode' => 'PJ009',
                'penjualan_tanggal' => '2024-02-09',
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Boby Rozak',
                'penjualan_kode' => 'PJ010',
                'penjualan_tanggal' => '2024-02-10',
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
