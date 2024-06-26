<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Payment;

use App\Models\Logevent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
            'ammount' => 'required',
            'comment' => 'required',
        ]);



        $ammount = $request->get('ammount');
        $type = $request->get('type');

        $myinvoice = Invoice::whereId($request->get('invoice_id'))->first();
        $invoice_type = $myinvoice->type;
        // $debt = $myinvoice->total - $myinvoice->payments->sum('ammount');
        $debt = $myinvoice->balance;
        // $debt = number_format((float) $debt, 2, '.', '');





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
                $debt = number_format((float) $debt, 5, '.', '');
                $tmp = number_format((float) $tmp, 5, '.', '');

                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error.1s El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }



            } else {
                $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                //Aqui valido que el pago no exceda la deuda en la prefactura
                $tmp = $ammount / $rate_exchange;
                $debt = number_format((float) $debt, 5, '.', '');
                $tmp = number_format((float) $tmp, 5, '.', '');

                error_log($tmp);
                error_log($debt);


                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error.2s El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }
            }
        } else {
            // Si NO hay cambio en la divisa del pago, respecto de la divisa de la factura
            $formFields = array_merge($formFields, array('ammount' => $ammount));
            //Aqui valido que el pago no exceda la deuda en la prefactura
            $debt = number_format((float) $debt, 5, '.', '');
            $ammount = number_format((float) $ammount, 5, '.', '');
            if ($ammount > $debt) {
                return Redirect::back()->withErrors(['msg' => "Error.3s El monto del pago ingresado $type$ $ammount excede la cantidad a liquidar $invoice_type$ $debt"]);
            }

        }


        // $formFields = array_merge($formFields, array('invoice_id' => $request->get('invoice_id')));


        //FROM THE MODEL
        try {
            $payment = Payment::create($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newpayment')->with('message', $errorInfo);
        }


        $mymessage = "Ingreso Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$payment->id}) Monto ({$payment->type}{$payment->ammount}) Cuenta asociada ({$payment->account_id}) Contrato Asociado ({$payment->lease_id}) Recibo Asociado ({$payment->invoice_id}) Fecha ({$payment->date}) Comentario ({$payment->comment})";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
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

        $mymessage = "Ingreso Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$payment->id}) Monto ({$payment->type}{$payment->ammount}) Cuenta asociada ({$payment->account_id}) Contrato Asociado ({$payment->lease_id}) Recibo Asociado ({$payment->invoice_id}) Fecha ({$payment->date}) Comentario ({$payment->comment})";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
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

        // $debt = number_format((float) $debt, 5, '.', '');



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
                $debt = number_format((float) $debt, 5, '.', '');
                $tmp = number_format((float) $tmp, 5, '.', '');
                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error.1u El monto del pago ingresado $type$ $ammount ( $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                }

            } else {
                //Si la Divisa del Update cambia respecto del Recibo
                $formFields = array_merge($formFields, array('ammount_exchange' => $request->get('ammount')));
                if ($request->get('type') == 'USD') {
                    $formFields = array_merge($formFields, array('ammount' => $ammount * $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount * $rate_exchange;
                    $debt = number_format((float) $debt, 5, '.', '');
                    $tmp = number_format((float) $tmp, 5, '.', '');
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error.2u El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }



                } else {
                    $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount / $rate_exchange;
                    $debt = number_format((float) $debt, 5, '.', '');
                    $tmp = number_format((float) $tmp, 5, '.', '');
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error.3u El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
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
                $debt = number_format((float) $debt, 5, '.', '');
                $tmp = number_format((float) $tmp, 5, '.', '');
                if ($tmp > $debt) {
                    return Redirect::back()->withErrors(['msg' => "Error.4u El monto del pago ingresado $type$ $ammount  ($invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
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
                    $debt = number_format((float) $debt, 5, '.', '');
                    $tmp = number_format((float) $tmp, 5, '.', '');
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error.5u El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
                    }



                } else {
                    $formFields = array_merge($formFields, array('ammount' => $ammount / $rate_exchange));
                    //Aqui valido que el pago no exceda la deuda en la prefactura
                    $tmp = $ammount / $rate_exchange;
                    $debt = number_format((float) $debt, 5, '.', '');
                    $tmp = number_format((float) $tmp, 5, '.', '');
                    if ($tmp > $debt) {
                        return Redirect::back()->withErrors(['msg' => "Error.6u El monto del pago ingresado $type$ $ammount (Tipo de cambio $rate_exchange / $invoice_type$$tmp ) excede la cantidad a liquidar $invoice_type$ $debt"]);
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

        $mymessage = "Ingreso Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$payment->id}) Monto ({$payment->type}{$payment->ammount}) Cuenta asociada ({$payment->account_id}) Contrato Asociado ({$payment->lease_id}) Recibo Asociado ({$payment->invoice_id}) Fecha ({$payment->date}) Comentario ({$payment->comment})";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
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
