<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\Position;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{

    public function getMasterIndex()
    {

        $client = new Client();
        $response = $client->get('https://favaa.co.id/api/outlet?key=a2c1ed71bcc06ce5ca27900d24a5e2a257fe35e4');
        $getData = json_decode($response->getBody()->getContents());
        $dataOutlets = $getData->data;
        foreach ($dataOutlets as $item) {
            $createDataOutlet = Outlet::firstOrCreate(['id' => $item->id_ot,
            ],
                ['nama_ot' => $item->nama_ot,
                    'alamat_ot' => $item->alamat_ot,
                    'kontak_ot' => $item->kontak_ot,
                    'keterangan' => $item->keterangan,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                ]);
            if ($createDataOutlet->wasRecentlyCreated) {
                Session::flash('success-add-outlet', 'Data '. $item->nama_ot .' ditambahkan dari server');
            }
        }

        $existingOutlets = Outlet::all();
        foreach ($existingOutlets as $existingOutlet) {
            $found = false;
            foreach ($dataOutlets as $item) {
                if ($existingOutlet->id == $item->id_ot) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $existingOutlet->delete();
                Session::flash('success-delete-outlet', 'Data'. $existingOutlet->nama_ot .'dihapus dari server');
            }
        }


        $dataPosition = Position::all();
        return view('dashboard.master', [
            "title" => 'FAVAA HR | Master',
            "dataOutlet" => $dataOutlets,
            "dataPosition" => $dataPosition,
        ]);
    }


}
