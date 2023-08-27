<?php

namespace App\Livewire\Dashboard;

use App\Models\Outlet;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Position;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Master extends Component
{
    use WithPagination;

    public $showCreatedPositionForm = false;
    public $editMode = false;

    public function showForm()
    {
        $this->showCreatedPositionForm = true;
    }

    public function closeForm()
    {
        $this->showCreatedPositionForm = false;
        $this->reset();
    }


    #[Rule('required|min:3|max:50')]
    public $position_name;
    #[Rule('required|min:3|max:255')]
    public $position_description;

    public function createPosition()
    {
        $this->validate();
        Position::create([
            'name' => $this->position_name,
            'description' => $this->position_description,
        ]);
        $this->dispatch('success', [
            'message' => 'Data ' . $this->position_name . ' berhasil ditambahkan'
        ]);
        $this->reset();
    }
    public $position_id;
    public function editPosition($position_id)
    {
        $this->showForm();
        $this->editMode = true;
        $this->position_id = $position_id;
        $position = Position::findOrFail($position_id);
        $this->position_name = $position->name;
        $this->position_description = $position->description;
    }

    public function updatePosition()
    {
        $this->validate();
        $position = Position::findOrFail($this->position_id);
        $position->update([
            'name' => $this->position_name,
            'description' => $this->position_description,
        ]);
        $this->dispatch('success', [
            'message' => 'Data ' . $this->position_name . ' berhasil diubah'
        ]);
        $this->reset();
        $this->editMode = false;
        $this->closeForm();
    }

    public function deletePosition($position_id)
    {
        try {
            $position = Position::findOrFail($position_id);
            $position->delete();
            $this->dispatch('success', [
                'message' => 'Data ' . $position->name . ' berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat menghapus data';
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                $errorMessage = 'Gagal menghapus data karena ada keterkaitan data lain.';
            }
            $this->dispatch('error', [
                'message' => $errorMessage
            ]);
        }
    }

    public function render()
    {
        $client = new Client();
        $response = $client->get('https://favaa.co.id/api/outlet?key=a2c1ed71bcc06ce5ca27900d24a5e2a257fe35e4');
        $getData = json_decode($response->getBody()->getContents());
        $dataOutlets = $getData->data;
        foreach ($dataOutlets as $item) {
            $createDataOutlet = Outlet::firstOrCreate(
                [
                    'id' => $item->id_ot,
                ],
                [
                    'nama_ot' => $item->nama_ot,
                    'alamat_ot' => $item->alamat_ot,
                    'kontak_ot' => $item->kontak_ot,
                    'keterangan' => $item->keterangan,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                ]
            );
            if ($createDataOutlet->wasRecentlyCreated) {
                Session::flash('success-add-outlet', 'Data ' . $item->nama_ot . ' ditambahkan dari server');
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
                Session::flash('success-delete-outlet', 'Data' . $existingOutlet->nama_ot . 'dihapus dari server');
            }
        }


        $dataPosition = Position::latest()->paginate(5);
        return view('livewire.dashboard.master', [
            "title" => 'FAVAA HR | Master',
            "dataOutlet" => $dataOutlets,
            "dataPosition" => $dataPosition,
        ]);
    }
}
