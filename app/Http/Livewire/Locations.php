<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;

class Locations extends Component
{

	public $locations, $location, $location_id;
    public $isOpen = 0;

    public function render()
    {
    	$this->locations = Location::latest()->get();
        return view('livewire.locations');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->location = '';
        $this->location_id = '';
    }

    public function store()
    {
        $this->validate([
            'location' => 'required|unique:locations,location,'.$this->location_id
        ]);

        Location::updateOrCreate(['id' => $this->location_id], [
            'location' => $this->location
        ]);

        session()->flash('message', 
            $this->location_id ? 'Location Updated Successfully.' : 'Location Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $this->location_id = $id;
        $this->location = $location->location;
        $this->openModal();
    }

    public function delete($id)
    {
        Location::find($id)->delete();
        session()->flash('message', 'Location Deleted Successfully.');

    }
}
