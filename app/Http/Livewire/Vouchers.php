<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Voucher;
use App\Models\Location;

class Vouchers extends Component
{

	public $locations, $vouchers, $discvouc, $desc, $location, $voucher_id;
    public $isOpen = 0;

    public function render()
    {
    	$this->locations = Location::all()->pluck('location', 'location');
    	$this->vouchers = Voucher::latest()->get();
        return view('livewire.vouchers');
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
        $this->discvouc = '';
        $this->desc = '';
        $this->location = '';
        $this->voucher_id = '';
    }

    public function store()
    {
        $this->validate([
            'discvouc' => 'required|max:10|unique:vouchers,discvouc,'.$this->voucher_id,
            'desc' => 'required',
            'location' => 'required'
        ]);

        Voucher::updateOrCreate(['id' => $this->voucher_id], [
            'discvouc' => $this->discvouc,
            'desc' => $this->desc,
            'location' => serialize($this->location)
        ]);

        session()->flash('message', 
            $this->voucher_id ? 'Voucher Updated Successfully.' : 'Voucher Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $this->voucher_id = $id;
        $this->discvouc = $voucher->discvouc;
        $this->desc = $voucher->desc;
        $this->location = unserialize($voucher->location);
        $this->openModal();
    }

    public function delete($id)
    {
        Voucher::find($id)->delete();
        session()->flash('message', 'Voucher Deleted Successfully.');

    }
}
