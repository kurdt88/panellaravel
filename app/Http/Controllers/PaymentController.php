<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Payment;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{

    public function index()
    {

        return view('listPayments', [
            // 'payments' => Payment::latest()->simplePaginate(10)
            'payments' => Payment::latest()->get()

        ]);
    }


    public function create()
    {

        return view('createPayment', [
            'leases' => Lease::all(),
            'accounts' => Account::all()

        ]);

    }


    //Store Data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'lease_id' => 'required',
            'account_id' => 'required',
            // 'concept' => 'required',
            'type' => 'required',
            'date' => 'required',
            'invoice_id' => 'required',
            // 'ammount' => 'required',
            'comment' => 'required',
        ]);



        $ammount = $request->get('ammount');
        $type = $request->get('type');

        $myinvoice = Invoice::whereId($request->get('invoice_id'))->first();
        $invoice_type = $myinvoice->type;
        // $debt = $myinvoice->total - $myinvoice->payments->sum('ammount');
        $debt = $myinvoice->balance;
        $debt = number_format((float) $debt, 2, '.', '');





        // Si hay cambio en la divisa del pago, respecto de la divisa de la prefactura
        if ($rate_exchange = $request->get('rate_exchange')) {
            // Se guarda tipo de cambio y monto en la nva divisa
            $formFields = array_merge($formFields, array('rate_exchange' => $rate_exchange));
            $formFields = array_merge($formFields, array('ammount_exchange' => $request->get('ammount')));

            //Se guarda el monto en la divisa de la prefactura
            if ($request->get('type') == 'USD') {
                $formFields = array_merge($formFields, array('ammount' => $ammount * $rate_exchange));
                //Aqui valido que el pago no exceda la deuda en la prefactura
                $tmp = $ammount * $rate_exchange;

                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }



            } else {
                $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                //Aqui valido que el pago no exceda la deuda en la prefactura
                $tmp = $ammount / $rate_exchange;
                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }
            }
        } else {
            // Si NO hay cambio en la divisa del pago, respecto de la divisa de la factura
            $formFields = array_merge($formFields, array('ammount' => $ammount));
            //Aqui valido que el pago no exceda la deuda en la prefactura
            if ($ammount > $debt) {
                return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount excede la cantidad a liquidar $invoice_type$ $debt"]);
            }

        }


        // $formFields = array_merge($formFields, array('invoice_id' => $request->get('invoice_id')));


        //FROM THE MODEL
        try {
            Payment::create($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newpayment')->with('message', $errorInfo);
        }

        return redirect('/payments')->with('message', 'Ingreso creado');
    }

    public function destroy(Payment $payment)
    {

        try {
            $payment->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/payments')->with('message', $errorInfo);
        }
        return redirect('/payments')->with('message', 'Ingreso eliminado');

    }

    public function edit(Payment $payment)
    {
        return view('editPayment', [
            'payment' => $payment,
            'accounts' => Account::all(),
            'leases' => Lease::all()
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        // dd($request->file('logo'));

        $formFields = $request->validate([
            'lease_id' => 'required',
            'account_id' => 'required',
            // 'concept' => 'required',
            'type' => 'required',
            'date' => 'required',
            'invoice_id' => 'required',
            'ammount' => 'required',
            'comment' => 'required',
        ]);


        $ammount = $request->get('ammount');
        $type = $request->get('type');

        $myinvoice = Invoice::whereId($request->get('invoice_id'))->first();
        $invoice_type = $myinvoice->type;
        // $debt = $myinvoice->total - $myinvoice->payments->sum('ammount') + $payment->ammount;
        $debt = $myinvoice->balance + $payment->ammount;

        $debt = number_format((float) $debt, 2, '.', '');



        //Si NO hay cambio de DIVISA en el update
        if ($type == $payment->type) {
            //Simplemente se toman los valores de los campos y se guardan
            if ($rate_exchange = $request->get('rate_exchange')) {
                $formFields = array_merge($formFields, array('rate_exchange' => $rate_exchange));
            }
            //Si la Divisa del Update es igual que en el Recibo
            if ($invoice_type == $type) {
                $formFields = array_merge($formFields, array('ammount' => $request->get('ammount')));

                //Aqui valido que el pago no exceda la deuda en la prefactura
                $tmp = $ammount;
                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error.a El monto del pago ingresado $type$ $ammount ( $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }

            } else {
                //Si la Divisa del Update cambia respecto del Recibo
                $formFields = array_merge($formFields, array('ammount_exchange' => $request->get('ammount')));
                if ($request->get('type') == 'USD') {
                    $formFields = array_merge($formFields, array('ammount' => $ammount * $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount * $rate_exchange;

                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }



                } else {
                    $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount / $rate_exchange;
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }
                }

            }
        } else {
            //Si hay cambio de divisa en el Update lo que sigue es revisar la divisa en el Recibo. Si son iguales NO se necesitan los campos con tipo de cambio
            if ($invoice_type == $type) {
                $formFields = array_merge($formFields, array('ammount' => $ammount));
                $formFields = array_merge($formFields, array('rate_exchange' => null));
                $formFields = array_merge($formFields, array('ammount_exchange' => null));
                //Aqui valido que el pago no exceda la deuda en la prefactura
                $tmp = $ammount;
                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount  ($invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }
            } else {
                if ($rate_exchange = $request->get('rate_exchange')) {
                    $formFields = array_merge($formFields, array('rate_exchange' => $rate_exchange));
                }
                $formFields = array_merge($formFields, array('ammount_exchange' => $request->get('ammount')));
                if ($request->get('type') == 'USD') {
                    $formFields = array_merge($formFields, array('ammount' => $ammount * $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount * $rate_exchange;

                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }



                } else {
                    $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount / $rate_exchange;
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error. El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }
                }


            }



        }



        //FROM THE MODEL
        try {
            $payment->update($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('/newpayment')->with('message', $errorInfo);
        }

        return redirect('/payments')->with('message', 'Ingreso actualizado');
    }

    public function show(Payment $payment)
    {
        return view('showPayment', [
            'payment' => $payment
        ]);
    }


    public function getpdf(Payment $payment)
    {


        $pdf = Pdf::loadView('paymentpdf', ['payment' => $payment]);

        return $pdf->stream();
    }
}
