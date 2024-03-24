<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pegawai')->insert([
            [
                'id' => Str::uuid(),
                'nama' => 'Muhammad Alwi',
                'tempat_lahir' => 'Sorong',
                'tanggal_lahir' => new Carbon('1998-03-10'),
                'nip_lama' => '11111',
                'nip_baru' => '55555',
                'tmt_golongan' => new Carbon('2020-04-10'),
                'tmt_jabatan' => new Carbon('2021-04-11'),
                'kepala_sekolah' => false,
                'jurusan' => 'Informatika',
                'tahun_lulus' => '2020',
                'pendidikan_terakhir_id' => 9,
                'keturunan_id' => 3,
                'golongan_id' => 6,
                'jabatan_id' => 2,
                'agama_id' => 1,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Katon Suwida',
                'tempat_lahir' => 'Biak',
                'tanggal_lahir' => new Carbon('1998-10-10'),
                'nip_lama' => '231233',
                'nip_baru' => '959432211',
                'tmt_golongan' => new Carbon('2019-04-10'),
                'tmt_jabatan' => new Carbon('2019-04-11'),
                'kepala_sekolah' => false,
                'jurusan' => 'TKJ',
                'tahun_lulus' => '2020',
                'pendidikan_terakhir_id' => 4,
                'keturunan_id' => 3,
                'golongan_id' => 2,
                'jabatan_id' => 5,
                'agama_id' => 1,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Muhammad Iriansyah',
                'tempat_lahir' => 'Abepura',
                'tanggal_lahir' => new Carbon('1996-06-05'),
                'nip_lama' => '91710097',
                'nip_baru' => '2022087371',
                'tmt_golongan' => new Carbon('2019-04-10'),
                'tmt_jabatan' => new Carbon('2019-04-11'),
                'kepala_sekolah' => true,
                'jurusan' => 'Informatika',
                'tahun_lulus' => '2020',
                'pendidikan_terakhir_id' => 9,
                'keturunan_id' => 3,
                'golongan_id' => 2,
                'jabatan_id' => 5,
                'agama_id' => 1,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Fahmi Roihan',
                'tempat_lahir' => 'Serui',
                'tanggal_lahir' => new Carbon('1996-03-12'),
                'nip_lama' => '11111',
                'nip_baru' => '55555',
                'tmt_golongan' => new Carbon('2018-04-10'),
                'tmt_jabatan' => new Carbon('2019-04-11'),
                'kepala_sekolah' => false,
                'jurusan' => 'Informatika',
                'tahun_lulus' => '2019',
                'pendidikan_terakhir_id' => 9,
                'keturunan_id' => 2,
                'golongan_id' => 1,
                'jabatan_id' => 4,
                'agama_id' => 2,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Samuel Pujai',
                'tempat_lahir' => 'Paniai',
                'tanggal_lahir' => new Carbon('1994-03-12'),
                'nip_lama' => '232111',
                'nip_baru' => '43500101',
                'tmt_golongan' => new Carbon('2016-04-11'),
                'tmt_jabatan' => new Carbon('2017-04-12'),
                'kepala_sekolah' => false,
                'jurusan' => 'Elektro',
                'tahun_lulus' => '2018',
                'pendidikan_terakhir_id' => 8,
                'keturunan_id' => 1,
                'golongan_id' => 4,
                'jabatan_id' => 6,
                'agama_id' => 3,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Nahor Wasahe',
                'tempat_lahir' => 'Intan Jaya',
                'tanggal_lahir' => new Carbon('1994-12-11'),
                'nip_lama' => '232111',
                'nip_baru' => '43500101',
                'tmt_golongan' => new Carbon('2016-04-10'),
                'tmt_jabatan' => new Carbon('2017-04-11'),
                'kepala_sekolah' => false,
                'jurusan' => 'Mesin',
                'tahun_lulus' => '2018',
                'pendidikan_terakhir_id' => 4,
                'keturunan_id' => 1,
                'golongan_id' => 4,
                'jabatan_id' => 6,
                'agama_id' => 3,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }
}
