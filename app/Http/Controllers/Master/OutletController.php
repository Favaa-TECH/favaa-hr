<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'opening_date' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData) {
            Outlet::create($request->all());
            $request->session()->flash('success', 'Data Outlet berhasil disimpan!');
            return redirect()->route('master-index');
        } else {
            // Tindakan yang diambil ketika validasi gagal
            return redirect()->back()->withErrors('Terjadi kesalahan validasi')->withInput();
        }
    }

    public function delete($id)
    {
        $data = Outlet::findOrFail($id);
        $deleteData = $data->delete();

        if ($deleteData) {
            return redirect()->route('master-index')->with('success', 'Data Outlet berhasil dihapus!');
        } else {
            return redirect()->route('master-index')->with('error', 'Terjadi Kesalahan saat menghapus data Outlet!');
        }
    }
}
