<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Rescission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class RescissionController extends Controller
{
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'lease_id' => 'required',
            'reason' => 'required',
            'date_start' => 'required',
        ]);


        try {

            DB::connection()->beginTransaction();

            Rescission::create($formFields);

            $myinvoices = Invoice::where("lease_id", $request->get('lease_id'))
                ->where('concept', 'like', '%Renta%')
                ->get();


            foreach ($myinvoices as $invoice) {
                if (count($invoice->payments) == 0) {
                    $invoice->delete();
                }
            }
            $myinvoices = Invoice::where("lease_id", $request->get('lease_id'))
                ->where('concept', 'like', '%Depósito de Garantía%')
                ->get();


            foreach ($myinvoices as $invoice) {
                if (count($invoice->payments) == 0) {
                    $invoice->delete();
                }
            }




            DB::connection()->commit();


        } catch (QueryException $exception) {
            DB::connection()->rollBack();

            $errorInfo = $exception->getMessage();
            return Redirect::back()->with('message', $errorInfo);
        }

        return redirect('/leases')->with('message', 'Contrato cancelado');
    }
}
