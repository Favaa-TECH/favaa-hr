<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $dataEmployee = Employee::with('position', 'outlet')->paginate(10);
        return view('dashboard.employee', compact('dataEmployee'));
    }

    public function add()
    {
        $dataPosition = Position::all();
        $dataOutlet = Outlet::all();
        return view('dashboard.add-employee',[
            'dataPosition' => $dataPosition,
            'dataOutlet' => $dataOutlet
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'position_id' => 'required',
            'outlet_id' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData) {
            $employee = Employee::create($validatedData);

            // Mengunggah dan mengubah nama file foto
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $fileName = strtolower(str_replace(' ', '_', $employee->id . '_' . $employee->name)) . '.' . $extension;
                $file->storeAs('photos', $fileName, 'public');

                $employee->photo = $fileName;
                $employee->save();
            }

            $request->session()->flash('success', 'Data Karyawan berhasil disimpan!');
            return redirect()->route('employee');
        } else {
            // Tindakan yang diambil ketika validasi gagal
            return redirect()->back()->withErrors('Terjadi kesalahan validasi')->withInput();
        }
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);

        // Menghapus file gambar terkait
        if (!empty($employee->photo)) {
            Storage::disk('public')->delete('photos/' . $employee->photo);
        }

        // Menghapus data karyawan dari database
        $employee->delete();

        return redirect()->route('employee')->with('success', 'Data Karyawan berhasil dihapus!');
    }
}
