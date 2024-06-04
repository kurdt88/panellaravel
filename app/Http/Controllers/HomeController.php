<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Subproperty;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [

        ]);


    }


    public function welcome()
    {



        $resultadosusd = Account::where('type', 'USD')->get();
        $resultadosmxn = Account::where('type', 'MXN')->get();





        //OBTENIENDO EL % DE OCUPACION DE UNIDADES Y SUBUNIDADES
        $countpropertyleases = 0;
        foreach (Property::all() as $key => $property) {
            //Se filtra a la propiedad 1
            if ($property->id != 1) {
                $lastLease = Lease::where('property', $property->id)
                    ->where('subproperty_id', 1)
                    ->get()
                    ->last();
                if ($lastLease) {
                    if ($lastLease->isvalid == 1) {
                        $countpropertyleases++;
                    }
                }
            }
        }

        $countsubpropertyleases = 0;
        foreach (Subproperty::all() as $key => $subproperty) {
            //Se filtra a la subpropiedad 1
            if ($subproperty->id != 1) {
                $lastLease = $subproperty->leases->last();
                if ($lastLease) {
                    if ($lastLease->isvalid == 1) {
                        $countsubpropertyleases++;
                    }
                }
            }
        }

        $countproperties = count(Property::all()) - 1;
        $countsubproperties = count(Subproperty::all()) - 1;

        // $raterentedproperties = 0;
        // if (($tmpcount = count(Property::all())) > 1) {
        //     $raterentedproperties = ($countpropertyleases / ($tmpcount - 1)) * 100;
        // }
        // $raterentedsubproperties = 0;
        // if (($tmpcount = count(Subproperty::all())) > 1) {
        //     $raterentedsubproperties = ($countsubpropertyleases / ($tmpcount - 1)) * 100;
        // }



        // OBTENIENDO LOS RECIBOS VENCIDOS
        $myoverdueinvoicesarraypayment = array();
        $myoverdueinvoicesarrayexpense = array();

        $myinvoices = Invoice::where('due_date', '<=', Carbon::now())->get();
        foreach ($myinvoices as $invoice) {
            if ($invoice->category == 'Ingreso') {
                if ($invoice->balance != 0) {
                    array_push($myoverdueinvoicesarraypayment, $invoice);
                }
            }

            if ($invoice->category == 'Egreso') {
                if ($invoice->balance != 0) {
                    array_push($myoverdueinvoicesarrayexpense, $invoice);
                }
            }
        }


        //OBTENIENDO LOS INGRESOS Y EGRESOS TOTALES DEL MES
        $now = Carbon::now();

        $paymentsmxn1 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'MXN')
            ->where('rate_exchange', null)
            ->get();

        $paymentsmxn2 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'MXN')
            ->whereNotNull('rate_exchange')
            ->get();

        $expensesmxn1 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'MXN')
            ->where('rate_exchange', null)
            ->get();

        $expensesmxn2 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'MXN')
            ->whereNotNull('rate_exchange')
            ->get();

        $paymentsusd1 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'USD')
            ->where('rate_exchange', null)
            ->get();

        $paymentsusd2 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'USD')
            ->whereNotNull('rate_exchange')
            ->get();

        $expensesusd1 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'USD')
            ->where('rate_exchange', null)
            ->get();

        $expensesusd2 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', 'USD')
            ->whereNotNull('rate_exchange')
            ->get();







        return view('bienvenido', [
            'paymentsmxn' => $paymentsmxn1->sum('ammount') + $paymentsmxn2->sum('ammount_exchange'),
            'expensesmxn' => $expensesmxn1->sum('ammount') + $expensesmxn2->sum('ammount_exchange'),
            'paymentsusd' => $paymentsusd1->sum('ammount') + $paymentsusd2->sum('ammount_exchange'),
            'expensesusd' => $expensesusd1->sum('ammount') + $expensesusd2->sum('ammount_exchange'),

            'cuentasusd' => $resultadosusd,
            'cuentasmxn' => $resultadosmxn,
            'myoverdueinvoicesarrayexpense' => count($myoverdueinvoicesarrayexpense),
            'myoverdueinvoicesarraypayment' => count($myoverdueinvoicesarraypayment),

            'countproperties' => $countproperties,
            'countsubproperties' => $countsubproperties,
            'countrentedproperties' => $countpropertyleases,
            'countrentedsubproperties' => $countsubpropertyleases,
        ]);
    }

    public function settings()
    {
        return view('showProfile');
    }
}
