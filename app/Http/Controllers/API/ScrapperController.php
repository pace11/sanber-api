<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ScrapperController extends ResponseController
{
    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $input = $request->all();
        $client = new Client(HttpClient::create(['timeout' => 5]));
    
        $website = $client->request('POST', 'http://180.250.219.60:81/cekpajak/', [
            'teks' => $input['nomor_plat'],
            'KD_PLAT' => $input['kode_plat'],
            'Submit' => '',
        ]);
        
        $data = $website->filter('tr')->each(function ($node) {
            return $node->text();
        });

        if (str_contains($data[1], 'tidak ditemukan')) {
            return $this->sendError('Kendaraan tidak ditemukan', false, 404);
        } else {
            $response = [
                'no_polisi' => explode(" : ", $data[1])[1],
                'tipe_kb' => explode(" : ", $data[2])[1],
                'jenis' => explode(" : ", $data[3])[1],
                'merek' => explode(" : ", $data[4])[1],
                'warna_kb' => explode(" : ", $data[5])[1],
                'tahun_buat' => explode(" : ", $data[6])[1],
                'tgl_akhir_pkb' => explode(" : ", $data[7])[1],
                'tgl_akhir_stnk' => explode(" : ", $data[8])[1],
                'detail_pkb' => $data[9],
                'deskripsi_pkb' => $data[10],
                'tahun_berjalan' => str_replace(' TUNGGAKAN DAFTAR', '', str_replace('TAHUN BERJALAN ', '', $data[11])),
                'simulasi_pkb' => [
                    explode(" ", $data[13]),
                    explode(" ", $data[14]),
                    explode(" ", $data[15]),
                ]
            ];
            return $this->sendResponse($response, "Fetch posts success");
        }
    }
}
