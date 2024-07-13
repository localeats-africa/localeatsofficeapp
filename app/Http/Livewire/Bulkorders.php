<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Vendor;
use App\Models\Platforms;
use App\Models\Orders;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Livewire\Field;
use App\Imports\OrderList;

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;

class Bulkorders extends Component
{
    public $file, $platform, $vendor, $orders;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove($i)
    {
       
        unset($this->inputs[$i]);
    }

    public function render()
    {
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        
        $this->platforms = Platforms::all();
        $this->vendors = Vendor::where('vendor_status', 'approved')
        ->get();

        $this->role  = Role::join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->get('role.role_name')
        ->pluck('role_name')->first();

        $this->orders = Orders::all();
        return view('livewire.bulkorders');
        
    }

    private function resetInputFields(){
        $this->platform = '';
        $this->vendor = '';
        $this->file = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
                'platform.0'    => 'required',
                'vendor.0'      => 'required',
                'file.0'        => 'required',
                'platform.*'    => 'required',
                'vendor.*'      => 'required',
                'file.*'        => 'required',
            ],
            [
                'platform.0.required'   => 'platform field is required',
                'vendor.0.required'     => 'vendor field is required',
                'file.0.required'       => 'vendor field is required',
                'platform.*.required'   => 'platform field is required',
                'vendor.*.required'     => 'vendor field is required',
                'file.*.required'       => 'vendor field is required',
            ]
        );

        foreach ($this->platform as $key => $value) {
           // Orders::create(['platform_id' => $this->platform[$key], 'vendor_id' => $this->vendor[$key]]);

            $platform_id = $this->platform[$key];
            $vendor_id = $this->vendor[$key];
            $import =  Excel::import(new OrderList($platform_id, $vendor_id), $file);
        }
  
        $this->inputs = [];
   
        $this->resetInputFields();
   
        session()->flash('order-status', 'Order Has Been Created Successfully.');

    }

}
