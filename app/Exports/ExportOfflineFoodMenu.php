<?php

namespace App\Exports;

use App\Models\OfflineFoodMenu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ExportOfflineFoodMenu implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OfflineFoodMenu::where('deleted_at', null)
        ->get(['swallow','soup', 'protein', 'others'])->take(2);
    }
}
