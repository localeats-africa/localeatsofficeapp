<?php

namespace App\Imports;

use App\Models\ExpensesList;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class ImportExpensesList implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct(string $vendor_id) {
        $this->vendor_id= $vendor_id;
    }


    public function model(array $row)
    {
        return new ExpensesList([
            //
            'item'      => $row[0],
            'added_by'  => Auth::id(),
            'vendor_id' => $this->vendor_id,
        ]);
    }
}
