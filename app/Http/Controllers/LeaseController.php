<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Models\Logevent;
use App\Models\Property;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class LeaseController extends Controller
{
    public function index()
    {

        return view('listLeases', [
            'leases' => Lease::latest()->get()
        ]);
    }


    public function index_valid()
    {

        $myleasesarray = array();
        $myleases = Lease::latest()->get();
        foreach ($myleases as $lease) {
            if ($lease->isvalid == 1 || $lease->isvalid == 5) {
                array_push($myleasesarray, $lease);
            }
        }

        return view('listLeases', [
            'leases' => $myleasesarray
        ]);
    }

    public function index_onrenovation()
    {

        $myleasesarray = array();
        $myleases = Lease::latest()->get();
        foreach ($myleases as $lease) {
            if ($lease->isvalid == 5) {
                array_push($myleasesarray, $lease);
            }
        }

        return view('listLeases', [
            'leases' => $myleasesarray
        ]);
    }

    public function create()
    {

        return view('createLease', [
            'properties' => Property::all()->reverse()->values(),
            'tenants' => Tenant::latest()->get()
        ]);

    }
    public function renew(Lease $lease)
    {

        return view('renewLease', [
            'lease' => $lease

        ]);

    }


    //Store Data
    public function store(Request $request)
    {



        $startString = substr($request->get('leaseperiod'), 0, 10);
        $endString = substr($request->get('leaseperiod'), -10);


        $formFields = $request->validate([
            'property' => 'required',
            'tenant' => 'required',
            'contract' => 'required',
            'rent' => 'required',
            'iva' => 'required',
            'type' => 'required',
            'leaseperiod' => 'required'

        ]);

        if ($subproperty_id = $request->get('subproperty_id')) {
            $formFields = array_merge($formFields, array('subproperty_id' => $subproperty_id));

        }

        $months_grace_period = 0;
        if ($months_grace_period = $request->get('months_grace_period')) {
            $formFields = array_merge($formFields, array('months_grace_period' => $months_grace_period));

        }

        if ($deposit = $request->get('deposit')) {
            $formFields = array_merge($formFields, array('deposit' => $deposit));

        }

        $formFields = array_merge($formFields, array('start' => $startString, 'end' => $endString));
        $iva_rate = 0;
        $iva_type = $request->get('iva');
        if ($iva_type == 'Exento') {
            $iva_rate = Tax::where('name', '=', 'Exento')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));

        } elseif ($iva_type == 'IVA') {
            $iva_rate = Tax::where('name', '=', 'IVA')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
        } elseif ($iva_type == 'IVA_RETENCIONES') {
            $iva_rate = Tax::where('name', '=', 'IVA_RETENCIONES')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
        }

        // dd($formFields);


        $lease_start_date = Carbon::createFromFormat('Y-m-d', $startString);
        $lease_end_date = Carbon::createFromFormat('Y-m-d', $endString);

        $diff = $lease_start_date->diffInMonths($lease_end_date);

        // if ($diff >= 12) {

        //FROM THE MODEL
        try {
            DB::connection()->beginTransaction();

            $mylease = Lease::create($formFields);
            $lease_id = $mylease->id;



            if ($deposit) {


                // Primero Crea la factura del Deposito de Garantia y despues ya genera las de las rentas
                $deposit_invoice_start_date = Carbon::createFromFormat('Y-m-d', $startString)->format('Y-m-d');
                $deposit_invoice_due_date = Carbon::createFromFormat('Y-m-d', $startString)->addDays(5)->format('Y-m-d');
                $concept = 'Ingreso General';

                // FORMULA DE IVA_RETENCIONES
                if ($iva_type == 'IVA_RETENCIONES') {

                    $iva_ammount_fixed = ($deposit * 0.16) - ($deposit * 0.10667) - ($deposit * 0.0125);

                } else {
                    $iva_ammount_fixed = $deposit * $iva_rate;
                }


                Invoice::create([
                    'lease_id' => $lease_id,
                    'sequence' => 1,
                    'ammount' => $deposit,
                    'type' => $request->get('type'),
                    'category' => "Ingreso",
                    'concept' => $concept,
                    'subconcept' => "DEPOSITO CONTRATO",
                    // 'iva' => $iva_type,
                    // 'iva_rate' => $iva_rate,

                    'iva' => 'Exento',
                    'iva_rate' => 0,
                    // 'iva_ammount' => $iva_ammount_fixed,
                    'iva_ammount' => 0,


                    'comment' => "Garantía establecida en el contrato",
                    'start_date' => $deposit_invoice_start_date,
                    'due_date' => $deposit_invoice_due_date

                ]);

            }


            for ($i = 1; $i <= $diff; $i++) {
                $sequence = $i;
                $invoice_start_date = Carbon::createFromFormat('Y-m-d', $startString)->addMonths($i - 1)->format('Y-m-d');
                $invoice_due_date = Carbon::createFromFormat('Y-m-d', $startString)->addMonths($i - 1)->addDays(5)->format('Y-m-d');
                if ($i <= $months_grace_period) {
                    $ammount = 0;
                    $concept = 'Ingreso General';
                    $subconcept = 'RENTA EXENTA POR PERIODO DE GRACIA';

                } else {
                    $ammount = $request->get('rent');
                    $concept = 'Ingreso General';
                    $subconcept = 'RENTA';
                }



                // FORMULA DE IVA_RETENCIONES
                if ($iva_type == 'IVA_RETENCIONES') {

                    $iva_ammount_fixed = ($ammount * 0.16) - ($ammount * 0.10667) - ($ammount * 0.0125);

                } else {
                    $iva_ammount_fixed = $ammount * $iva_rate;
                }


                Invoice::create([
                    'lease_id' => $lease_id,
                    'sequence' => $sequence,
                    'ammount' => $ammount,
                    'type' => $request->get('type'),
                    'category' => "Ingreso",
                    'concept' => $concept,
                    'subconcept' => $subconcept,
                    'iva' => $iva_type,
                    'iva_rate' => $iva_rate,
                    'iva_ammount' => $iva_ammount_fixed,
                    'comment' => "Recibo # " . $sequence,
                    'start_date' => $invoice_start_date,
                    'due_date' => $invoice_due_date

                ]);

                DB::connection()->commit();

            }
        } catch (QueryException $exception) {
            DB::connection()->rollBack();

            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newlease')->with('message', $errorInfo);
        }


        $mymessage = "Contrato Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | Contrato: ID ({$mylease->id}) Propiedad ({$mylease->propertyname}) Subpropiedad ({$mylease->subpropertyname}) Arrendatario ({$mylease->tenantname}) Inicio ({$mylease->start}) Fin ({$mylease->end}) Renta ({$mylease->type}{$mylease->rent})  IVA ({$mylease->iva}) Deposito ({$mylease->deposit}) Meses de Gracia ({$months_grace_period}) Comentario  ({$mylease->contract}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/leases')->with('message', 'Contrato creado');

        // } else {

        //     return Redirect::back()->withErrors(['msg' => "Error. El periodo seleccionado es menor a 12 meses : " . $request->get('leaseperiod')]);

        //     // return redirect('newlease')->with('message', "El periodo seleccionado es menor a 12 meses : " . $request->get('leaseperiod'));
        // }



    }

    public function destroy(Lease $lease)
    {
        try {
            $lease->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/leases')->with('message', $errorInfo);
        }



        $mymessage = "Contrato Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | Contrato: ID ({$lease->id}) Propiedad ({$lease->propertyname}) Subpropiedad ({$lease->subpropertyname}) Arrendatario ({$lease->tenantname}) Inicio ({$lease->start}) Fin ({$lease->end}) Renta ({$lease->type}{$lease->rent})  IVA ({$lease->iva}) Deposito ({$lease->deposit})  Comentario  ({$lease->contract}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/leases')->with('message', 'Contrato eliminado');

    }


    public function edit(Lease $lease)
    {
        return view('editLease', [
            'lease' => $lease,
            'properties' => Property::all(),
            'tenants' => Tenant::latest()->get()
        ]);


    }


    public function update(Request $request, Lease $lease)
    {

        $startString = substr($request->get('leaseperiod'), 0, 10);
        $endString = substr($request->get('leaseperiod'), -10);


        $formFields = $request->validate([
            'property' => 'required',
            'tenant' => 'required',
            'contract' => 'required',
            'rent' => 'required',
            'iva' => 'required',
            'type' => 'required',
            'leaseperiod' => 'required',

        ]);

        $formFields = array_merge($formFields, array('start' => $startString, 'end' => $endString));

        if ($subproperty_id = $request->get('subproperty_id')) {
            $formFields = array_merge($formFields, array('subproperty_id' => $subproperty_id));

        }

        if ($deposit = $request->get('deposit')) {
            $formFields = array_merge($formFields, array('deposit' => $deposit));

        }

        // $formFields = array_merge($formFields, array('start' => $startString, 'end' => $endString));



        $iva_rate = 0;
        if ($request->get('iva') == 'Exento') {
            $iva_rate = Tax::where('name', '=', 'Exento')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));

        } elseif ($request->get('iva') == 'IVA') {
            $iva_rate = Tax::where('name', '=', 'IVA')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
        } elseif ($request->get('iva') == 'IVA_RETENCIONES') {
            $iva_rate = Tax::where('name', '=', 'IVA_RETENCIONES')->first()->value;
            $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
        }




        //FROM THE MODEL
        try {
            // dd($formFields);
            $lease->update($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('/newlease')->with('message', $errorInfo);
        }

        $mymessage = "Contrato Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | Contrato: ID ({$lease->id}) Propiedad ({$lease->propertyname}) Subpropiedad ({$lease->subpropertyname}) Arrendatario ({$lease->tenantname}) Inicio ({$lease->start}) Fin ({$lease->end}) Renta ({$lease->type}{$lease->rent})  IVA ({$lease->iva}) Deposito ({$lease->deposit})  Comentario  ({$lease->contract}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/leases')->with('message', 'Contrato actualizado');
    }

    public function show(Lease $lease)
    {
        return view('showLease', [
            'lease' => $lease
        ]);
    }

    public function showMovements(Lease $lease)
    {
        return view('showLeaseMovements', [
            'lease' => $lease
        ]);
    }


    public function cancel(Lease $lease)
    {
        $myinvoicesarray = array();

        $myinvoices = Invoice::where("lease_id", $lease->id)
            ->where('subconcept', 'like', '%RENTA%')
            ->get();

        foreach ($myinvoices as $invoice) {
            if (count($invoice->payments) == 0) {
                array_push($myinvoicesarray, $invoice);
            }
        }
        $myinvoices = Invoice::where("lease_id", $lease->id)
            ->where('subconcept', 'like', '%DEPOSITO CONTRATO%')
            ->get();

        foreach ($myinvoices as $invoice) {
            if (count($invoice->payments) == 0) {
                array_push($myinvoicesarray, $invoice);
            }
        }

        return view('createRescission', [
            'lease' => $lease,
            'invoices' => $myinvoicesarray
        ]);
    }





    public function deleteinvoices(Lease $lease)
    {
        $myinvoicesarray = array();

        $myinvoices = Invoice::where("lease_id", $lease->id)
            ->get();

        foreach ($myinvoices as $invoice) {
            if (count($invoice->payments) == 0 && count($invoice->expenses) == 0) {
                array_push($myinvoicesarray, $invoice);
            }
        }


        return view('delInvoices', [
            'lease' => $lease,
            'invoices' => $myinvoicesarray
        ]);
    }




    public function delinvoices(Lease $lease)
    {

        try {
            DB::connection()->beginTransaction();

            $myinvoices = Invoice::where("lease_id", $lease->id)
                ->get();

            foreach ($myinvoices as $invoice) {
                if (count($invoice->payments) == 0 && count($invoice->expenses) == 0) {
                    Log::info("Recibo eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | Recibo: ID ({$invoice->id}) Monto ({$invoice->type} {$invoice->ammount}) Tipo ({$invoice->category}) Categoria ({$invoice->concept}) Concepto ({$invoice->subconcept}) Comentario ({$invoice->comment}) Contrato Asociado ({$invoice->lease_id}) ");
                    $invoice->delete();
                }
            }


            DB::connection()->commit();

        } catch (QueryException $exception) {
            DB::connection()->rollBack();

            $errorInfo = $exception->getMessage();
            return Redirect::back()->with('message', $errorInfo);
        }

        Log::info("Recibos eliminados en lote por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ")");
        return redirect('/leasemovements/' . $lease->id . '/')->with('message', 'Recibos eliminados');



    }




}
