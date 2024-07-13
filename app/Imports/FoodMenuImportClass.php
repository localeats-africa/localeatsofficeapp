<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FoodMenu;
use Auth;

class FoodMenuImportClass implements ToModel
{
    // public $request;
    /**
    * @param Collection $collection
    */

    public function  __construct(string $vendor_id) {
        $this->vendor_id= $vendor_id;
    }

    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        // Define how to create a model from the Excel row data

        return new FoodMenu([
            'item'      => $row[0],
            'price'     => $row[1],
            'added_by'  => Auth::id(),
            'vendor_id' => $this->vendor_id,
            // Add more columns as needed
        ]);
    }
}
