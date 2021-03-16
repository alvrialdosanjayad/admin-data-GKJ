<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JemaatImport;
use App\Imports\UsersImport;
use App\Exports\JemaatExport;

class ImportExportController extends Controller
{

    public function ImportJemaatExcel(Request $request)
    {
        # code...
        $post = $this->validate($request, [
            'importData' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new JemaatImport, $request->file('importData')->store('temp'));

        return response()->json($post);
    }

    public function ExportJemaatExcel()
    {
        return (new JemaatExport)->download('Backup-data-jemaat.xlsx');
    }
}
