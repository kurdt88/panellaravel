<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Logevent;
use App\Models\Rescission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

            $myrescission = Rescission::create($formFields);

            $myinvoices = Invoice::where("lease_id", $request->get('lease_id'))
                ->where('subconcept', 'like', '%RENTA%')
                ->get();


            foreach ($myinvoices as $invoice) {
                if (count($invoice->payments) == 0) {
                    $invoice->delete();
                }
            }
            $myinvoices = Invoice::where("lease_id", $request->get('lease_id'))
                ->where('subconcept', 'like', '%DEPOSITO CONTRATO%')
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

        $mymessage = "Contrato Cancelado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$myrescission->id}) Contrato Asociado ({$myrescission->lease_id}) Motivo ({$myrescission->reason}) Fecha inicia ({$myrescission->date_start})  ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/leases')->with('message', 'Contrato cancelado');
    }
}
