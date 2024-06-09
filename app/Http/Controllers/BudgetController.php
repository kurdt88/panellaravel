<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Logevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('createBudget', [
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'date' => 'required',
            'building_id' => 'required',

        ]);


        if ($year = substr($request->get('date'), 0, 4)) {
            $formFields = array_merge($formFields, array('year' => $year));

        }
        if ($month = substr($request->get('date'), -2)) {
            $formFields = array_merge($formFields, array('month' => $month));

        }

        if ($maintenance_budget_mxn = $request->get('maintenance_budget_mxn')) {
            $formFields = array_merge($formFields, array('maintenance_budget_mxn' => $maintenance_budget_mxn));
        }

        if ($maintenance_budget_usd = $request->get('maintenance_budget_usd')) {
            $formFields = array_merge($formFields, array('maintenance_budget_usd' => $maintenance_budget_usd));
        }
        if ($comment = $request->get('comment')) {
            $formFields = array_merge($formFields, array('comment' => $comment));
        }

        // dd($formFields);
        $building = $request->get('building_id');

        try {
            $budget = Budget::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/newbudget/' . $building)->with('message', $errorInfo);
        }



        $mymessage = "Presupuesto de Mantenimiento Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$budget->id}) Year ({$budget->year}) Month ({$budget->month}) PresupuestoMXN ({$budget->maintenance_budget_mxn}) PresupuestoUSD ({$budget->maintenance_budget_usd}) Unidad Hab Asociada ({$budget->building_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/buildingbudgets/' . $building)->with('message', 'Presupuesto de Mantenimiento creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        return view('editBudget', [
            'budget' => $budget
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $formFields = $request->validate([
            'building_id' => 'required',
            'year' => 'required',
            'month' => 'required',
        ]);


        if ($maintenance_budget_mxn = $request->get('maintenance_budget_mxn')) {
            $formFields = array_merge($formFields, array('maintenance_budget_mxn' => $maintenance_budget_mxn));
        }

        if ($maintenance_budget_usd = $request->get('maintenance_budget_usd')) {
            $formFields = array_merge($formFields, array('maintenance_budget_usd' => $maintenance_budget_usd));
        }

        if ($comment = $request->get('comment')) {
            $formFields = array_merge($formFields, array('comment' => $comment));
        }

        $building = $request->get('building_id');

        try {
            $budget->update($formFields);


        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('/buildingbudgets/' . $building)->with('message', $errorInfo);
        }

        $mymessage = "Presupuesto de Mantenimiento Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$budget->id}) Year ({$budget->year}) Month ({$budget->month}) PresupuestoMXN ({$budget->maintenance_budget_mxn}) PresupuestoUSD ({$budget->maintenance_budget_usd}) Unidad Hab Asociada ({$budget->building_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/buildingbudgets/' . $building)->with('message', 'Presupuesto de Mantenimiento actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        try {
            $budget->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/buildingbudgets/' . $budget->building->id)->with('message', $errorInfo);
        }

        $mymessage = "Presupuesto de Mantenimiento Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$budget->id}) Year ({$budget->year}) Month ({$budget->month}) PresupuestoMXN ({$budget->maintenance_budget_mxn}) PresupuestoUSD ({$budget->maintenance_budget_usd}) Unidad Hab Asociada ({$budget->building_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/buildingbudgets/' . $budget->building->id)->with('message', 'Presupuesto de Mtto eliminado');
    }




}
