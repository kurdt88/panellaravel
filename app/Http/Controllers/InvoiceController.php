<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Lease;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    public function index()
    {

        return view('listInvoices', [
            'invoices' => Invoice::latest()->get()

        ]);
    }


    public function index_active()
    {

        return view('listInvoices', [
            'invoices' => Invoice::where("start_date", '<=', Carbon::now())
                ->where('due_date', '>=', Carbon::now())
                ->get()

        ]);
    }

    public function index_overdue()
    {

        $myinvoicesarray = array();
        $myinvoices = Invoice::where('due_date', '<=', Carbon::now())->get();
        foreach ($myinvoices as $invoice) {
            if ($invoice->category == 'Ingreso') {
                if (($invoice->total - $invoice->payments->sum('ammount')) != 0) {
                    array_push($myinvoicesarray, $invoice);
                }
            }

            if ($invoice->category == 'Egreso') {
                if (($invoice->total - $invoice->expenses->sum('ammount')) != 0) {
                    array_push($myinvoicesarray, $invoice);
                }
            }
        }


        return view('listInvoices', [
            'invoices' => $myinvoicesarray
        ]);


    }


    public function index_active_payment()
    {

        $invoices = Invoice::where("start_date", '<=', Carbon::now())
            ->where("category", '=', 'Ingreso')
            ->where('due_date', '>=', Carbon::now())
            ->get();


        foreach ($invoices as $key => $invoice) {
            $debt = $invoice->ammount + $invoice->iva_ammount - $invoice->payments->sum('ammount');
            if ($debt == 0)
                unset($invoices[$key]);

        }
        // dd($invoices);


        return view('listInvoices', [
            'invoices' => $invoices
        ]);
    }

    public function index_active_expense()
    {


        $invoices = Invoice::where("start_date", '<=', Carbon::now())
            ->where("category", '=', 'Egreso')
            ->where('due_date', '>=', Carbon::now())
            ->get();
        // dd($invoices);

        foreach ($invoices as $key => $invoice) {
            $debt = $invoice->ammount + $invoice->iva_ammount - $invoice->expenses->sum('ammount');
            if ($debt == 0)
                unset($invoices[$key]);

        }



        return view('listInvoices', [
            'invoices' => $invoices
        ]);

    }

    public function create()
    {

        return view('createInvoice', [
            'leases' => Lease::latest()->get()
        ]);

    }



    public function store(Request $request)
    {

        if ($request->get('category') == 'Ingreso' && $request->get('lease_id') == 1) {

            return Redirect::back()->withErrors(['msg' => "No se permite la creación de Recibos de Ingreso no asociados a un contrato."]);

        } else {
            # code...
            $startString = substr($request->get('invoiceperiod'), 0, 10);
            $endString = substr($request->get('invoiceperiod'), -10);


            $formFields = $request->validate([
                'lease_id' => 'required',
                'concept' => 'required',
                'ammount' => 'required',
                'type' => 'required',
                'iva' => 'required',
                'category' => 'required',
                'comment' => 'required'

            ]);



            if ($property_id = $request->get('property_id')) {
                $formFields = array_merge($formFields, array('property_id' => $property_id));
            }
            if ($subproperty_id = $request->get('subproperty_id')) {
                $formFields = array_merge($formFields, array('subproperty_id' => $subproperty_id));
            }


            if ($request->get('iva') == 'Exento') {
                $iva_rate = Tax::where('name', '=', 'Exento')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));

            } elseif ($request->get('iva') == 'IVA') {
                $iva_rate = Tax::where('name', '=', 'IVA')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
            } elseif ($request->get('iva') == 'IVA_ISR') {
                $iva_rate = Tax::where('name', '=', 'IVA_ISR')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
            }



            $formFields = array_merge($formFields, array('sequence' => 1, 'start_date' => $startString, 'due_date' => $endString));

            try {
                Invoice::create($formFields);

            } catch (QueryException $exception) {
                $errorInfo = $exception->getMessage();
                return redirect('newinvoice')->with('message', $errorInfo);
            }
            return redirect('/invoices')->with('message', 'Recibo creado');
        }




    }


    public function show(Invoice $invoice)
    {
        return view('showInvoice', [
            'invoice' => $invoice
        ]);
    }

    public function getpdf(Invoice $invoice)
    {


        $pdf = Pdf::loadView('invoicepdf', ['invoice' => $invoice]);

        return $pdf->stream();
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/invoices')->with('message', $errorInfo);
        }
        return redirect('/invoices')->with('message', 'Recibo eliminado');

    }


    public function edit(Invoice $invoice)
    {
        return view('editInvoice', [
            'invoice' => $invoice,
            'leases' => Lease::all()
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {




        if ($request->get('category') == 'Ingreso' && $request->get('lease_id') == 1) {

            return Redirect::back()->withErrors(['msg' => "No se permite la creación de Recibos de Ingreso no asociadas a un contrato."]);

        } else {
            $startString = substr($request->get('invoiceperiod'), 0, 10);
            $endString = substr($request->get('invoiceperiod'), -10);


            $formFields = $request->validate([
                'lease_id' => 'required',
                'concept' => 'required',
                'ammount' => 'required',
                'type' => 'required',
                'iva' => 'required',
                'category' => 'required',
                'comment' => 'required'

            ]);

            if ($request->get('iva') == 'Exento') {
                $iva_rate = Tax::where('name', '=', 'Exento')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));

            } elseif ($request->get('iva') == 'IVA') {
                $iva_rate = Tax::where('name', '=', 'IVA')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
            } elseif ($request->get('iva') == 'IVA_ISR') {
                $iva_rate = Tax::where('name', '=', 'IVA_ISR')->first()->value;
                $iva_ammount = $request->get('ammount') * $iva_rate;
                $formFields = array_merge($formFields, array('iva_ammount' => $iva_ammount));
                $formFields = array_merge($formFields, array('iva_rate' => $iva_rate));
            }

            $formFields = array_merge($formFields, array('sequence' => 1, 'start_date' => $startString, 'due_date' => $endString));

            try {
                $invoice->update($formFields);

            } catch (QueryException $exception) {
                $errorInfo = $exception->getMessage();
                return redirect('newinvoice')->with('message', $errorInfo);
            }
            return redirect('/invoices')->with('message', 'Recibo actualizado');
        }
    }


    public function getxml(Invoice $invoice)
    {

        return response()->xml($invoice);
    }


}
