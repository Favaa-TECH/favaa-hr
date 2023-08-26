<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        if ($validatedData) {
            Position::create($request->all());
            $request->session()->flash('success', 'Data Jabatan berhasil disimpan!');
            return redirect()->route('master.index');
        } else {
            // Tindakan yang diambil ketika validasi gagal
            return redirect()->back()->withErrors('Terjadi kesalahan validasi')->withInput();
        }
    }

    public function delete($id)
    {
        $data = Position::findOrFail($id);
        $deleteData = $data->delete();

        if ($deleteData) {
            return redirect()->route('master.index')->with('success', 'Data Position berhasil dihapus!');
        } else {
            return redirect()->route('master.index')->with('error', 'Terjadi Kesalahan saat menghapus data Position!');
        }
    }
}
