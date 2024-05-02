<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Expenseimg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listExpenses', [
            'expenses' => Expense::latest()->get()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createExpense', [
            'leases' => Lease::all(),
            'accounts' => Account::all()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $files_images = $request->file('images');
        $files_others = $request->file('other_files');


        // dd($files);
        $formFields = $request->validate([
            'lease_id' => 'required',
            'account_id' => 'required',
            'invoice_id' => 'required',
            'type' => 'required',
            'description' => 'required',
            // 'ammount' => 'required',
            'date' => 'required',
        ]);

        if ($supplier_id = $request->get('supplier_id')) {
            $formFields = array_merge($formFields, array('supplier_id' => $supplier_id));

        }



        $ammount = $request->get('ammount');
        $type = $request->get('type');

        $myinvoice = Invoice::whereId($request->get('invoice_id'))->first();
        $invoice_type = $myinvoice->type;
        $debt = $myinvoice->total - $myinvoice->expenses->sum('ammount');





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




        if ($maintenance_budget = $request->get('maintenance_budget')) {
            if ($maintenance_budget == 'Si') {
                $formFields = array_merge($formFields, array('maintenance_budget' => 1));
            }
        }




        try {
            DB::connection()->beginTransaction();

            $myexpense = Expense::create($formFields);

            if ($request->hasFile('images')) {
                foreach ($files_images as $file) {
                    Expenseimg::create([
                        'expense_id' => $myexpense->id,
                        'type' => 'image',
                        'original_name' => $file->getClientOriginalName(),
                        'image' => $file->store('expenses.images', 'spaces'),

                    ]);
                }
            }

            if ($request->hasFile('other_files')) {

                foreach ($files_others as $file) {
                    Expenseimg::create([
                        'expense_id' => $myexpense->id,
                        'type' => 'file',
                        'original_name' => $file->getClientOriginalName(),
                        'image' => $file->store('expenses.files', 'spaces'),

                    ]);
                }
            }

            DB::connection()->commit();

        } catch (QueryException $exception) {
            DB::connection()->rollBack();

            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newexpense')->with('message', $errorInfo);
        }

        return redirect('/expenses')->with('message', 'Egreso creado');
    }


    /**
     * Update the specified resource in storage.
     */

    public function destroy(Expense $expense)
    {

        try {
            $expense->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/expenses')->with('message', $errorInfo);
        }
        return redirect('/expenses')->with('message', 'Egreso eliminado');

    }

    public function edit(Expense $expense)
    {
        return view('editExpense', [
            'expense' => $expense,
            'accounts' => Account::all(),
            'leases' => Lease::all()
        ]);
    }


    public function update(Request $request, Expense $expense)
    {
        $files_images = $request->file('images');
        $files_others = $request->file('other_files');

        $formFields = $request->validate([
            'lease_id' => 'required',
            'account_id' => 'required',
            'invoice_id' => 'required',
            'type' => 'required',
            'description' => 'required',
            'ammount' => 'required',
            'date' => 'required',
        ]);

        if ($supplier_id = $request->get('supplier_id')) {
            $formFields = array_merge($formFields, array('supplier_id' => $supplier_id));

        }

        try {
            $expense->update($formFields);

            if ($request->hasFile('images')) {
                foreach ($files_images as $file) {
                    Expenseimg::create([
                        'expense_id' => $expense->id,
                        'type' => 'image',
                        'original_name' => $file->getClientOriginalName(),
                        'image' => $file->store('expenses.images', 'public'),

                    ]);
                }
            }

            if ($request->hasFile('other_files')) {

                foreach ($files_others as $file) {
                    Expenseimg::create([
                        'expense_id' => $expense->id,
                        'type' => 'file',
                        'original_name' => $file->getClientOriginalName(),
                        'image' => $file->store('expenses.files', 'public'),

                    ]);
                }
            }


        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return Redirect::back()->with('message', $errorInfo);
        }

        return redirect('/expenses')->with('message', 'Egreso actualizado');
    }

    public function show(Expense $expense)
    {
        return view('showExpense', [
            'expense' => $expense
        ]);
    }

}
