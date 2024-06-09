<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listAccounts', [
            'accounts' => Account::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createAccount', [
            'landlords' => Landlord::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'landlord_id' => 'required',
            'alias' => 'required',
            'bank' => 'required',
            'number' => 'required',
            'type' => 'required',
            'comment' => 'required',
        ]);


        try {
            $myaccount = Account::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newaccount')->with('message', $errorInfo);
        }

        Log::info("Cuenta Bancaria Creada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$myaccount->id}) Alias ({$myaccount->alias}) Banco ({$myaccount->bank}) Numero ({$myaccount->number}) Comentario ({$myaccount->comment}) Divisa ({$myaccount->type}) Propietario Asociado ({$myaccount->landlord_id}) ");

        return redirect('/accounts')->with('message', 'Cuenta Bancaria creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {

        return view('showAccount', [
            'account' => $account
        ]);
    }


    public function showMonthMovements(Account $account)
    {
        $now = Carbon::now();

        $payments = Payment::where("account_id", $account->id)
            ->whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->get();

        $expenses = Expense::where("account_id", $account->id)
            ->whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->get();

        return view('showAccountMovements', [
            'account' => $account,
            'payments' => $payments,
            'expenses' => $expenses,
            'period' => ' Mes: ' . $now->month . ' / ' . $now->year
        ]);
    }



    public function showAllMovements(Account $account)
    {

        $payments = Payment::where("account_id", $account->id)
            ->get();

        $expenses = Expense::where("account_id", $account->id)
            ->get();

        return view('showAccountMovements', [
            'account' => $account,
            'payments' => $payments,
            'expenses' => $expenses,
            'period' => 'Mostrando todos los movimientos'
        ]);
    }

    public function searchMovements(Account $account)
    {
        return view('searchMovements', [
            'account' => $account
        ]);
    }
    public function accountsearchmovements(Request $request, Account $account)
    {
        $startString = substr($request->get('searchperiod'), 0, 10);
        $endString = substr($request->get('searchperiod'), -10);
        $start_date = Carbon::createFromFormat('Y-m-d', $startString);
        $end_date = Carbon::createFromFormat('Y-m-d', $endString);

        $payments = Payment::where("account_id", $account->id)
            ->whereYear('date', '>=', $start_date->year)
            ->whereYear('date', '<=', $end_date->year)
            ->whereMonth('date', '>=', $start_date->month)
            ->whereMonth('date', '<=', $end_date->month)
            ->whereDay('date', '>=', $start_date->day)
            ->whereDay('date', '<=', $end_date->day)
            ->get();

        $expenses = Expense::where("account_id", $account->id)
            ->whereYear('date', '>=', $start_date->year)
            ->whereYear('date', '<=', $end_date->year)
            ->whereMonth('date', '>=', $start_date->month)
            ->whereMonth('date', '<=', $end_date->month)
            ->whereDay('date', '>=', $start_date->day)
            ->whereDay('date', '<=', $end_date->day)
            ->get();

        return view('showAccountMovements', [
            'account' => $account,
            'payments' => $payments,
            'expenses' => $expenses,
            'period' => $start_date->day . '/' . $start_date->month . '/' . $start_date->year . ' - ' . $end_date->day . '/' . $end_date->month . '/' . $end_date->year
        ]);
    }
    //


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('editAccount', [
            'account' => $account,
            'landlords' => Landlord::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $formFields = $request->validate([
            'landlord_id' => 'required',
            'alias' => 'required',
            'bank' => 'required',
            'number' => 'required',
            'type' => 'required',
            'comment' => 'required',
        ]);



        try {
            $account->update($formFields);


        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newaccount')->with('message', $errorInfo);
        }

        Log::info("Cuenta Bancaria actualizada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$account->id}) Alias ({$account->alias}) Banco ({$account->bank}) Numero ({$account->number}) Comentario ({$account->comment}) Divisa ({$account->type}) Propietario Asociado ({$account->landlord_id}) ");

        return redirect('/accounts')->with('message', 'Cuenta Bancaria actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {

        try {
            $account->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/accounts')->with('message', $errorInfo);
        }


        Log::info("Cuenta Bancaria eliminada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$account->id}) Alias ({$account->alias}) Banco ({$account->bank}) Numero ({$account->number}) Comentario ({$account->comment}) Divisa ({$account->type}) Propietario Asociado ({$account->landlord_id}) ");

        return redirect('/accounts')->with('message', 'Cuenta Bancaria eliminada');
    }
}
