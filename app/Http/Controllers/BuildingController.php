<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listBuildings', [
            'buildings' => Building::latest()->get()

        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createBuilding', [
            // 'leases' => Lease::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
        ]);


        try {
            Building::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newbuilding')->with('message', $errorInfo);
        }

        return redirect('/buildings')->with('message', 'Unidad Habitacional creada');
    }



    public function searchMovements(Building $building)
    {
        return view('searchBudgetMovements', [
            'building' => $building
        ]);
    }




    public function budgetsearchmovements(Request $request, Building $building)
    {
        $startString = substr($request->get('searchperiod'), 0, 10);
        $endString = substr($request->get('searchperiod'), -10);
        $start_date = Carbon::createFromFormat('Y-m-d', $startString);
        $end_date = Carbon::createFromFormat('Y-m-d', $endString);


        $myexpensesarray = array();
        foreach ($building->properties as $property) {
            foreach ($property->leases as $lease) {

                $expenses = Expense::where('lease_id', $lease->id)
                    ->where('maintenance_budget', 1)
                    ->whereYear('date', '>=', $start_date->year)
                    ->whereYear('date', '<=', $end_date->year)
                    ->whereMonth('date', '>=', $start_date->month)
                    ->whereMonth('date', '<=', $end_date->month)
                    ->whereDay('date', '>=', $start_date->day)
                    ->whereDay('date', '<=', $end_date->day)
                    ->get();


                foreach ($expenses as $expense) {
                    array_push($myexpensesarray, $expense);
                }
            }

            // Recuperando los egresos sin contrato asociado
            $invoices = Invoice::where("property_id", $property->id)
                ->whereYear('start_date', '>=', $start_date->year)
                ->whereYear('start_date', '<=', $end_date->year)
                ->whereMonth('start_date', '>=', $start_date->month)
                ->whereMonth('start_date', '<=', $end_date->month)
                ->whereDay('start_date', '>=', $start_date->day)
                ->whereDay('start_date', '<=', $end_date->day)
                ->get();

            foreach ($invoices as $invoice) {
                foreach ($invoice->expenses as $expense) {
                    if ($expense->maintenance_budget == 1) {
                        array_push($myexpensesarray, $expense);
                    }
                }
            }




        }



        return view('showBuildingMaintenanceExpenses', [
            'building' => $building,
            'expenses' => $myexpensesarray,
            'period' => $start_date->day . '/' . $start_date->month . '/' . $start_date->year . ' - ' . $end_date->day . '/' . $end_date->month . '/' . $end_date->year

        ]);



    }











    public function destroy(Building $building)
    {
        try {
            $building->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/buildings')->with('message', $errorInfo);
        }
        return redirect('/buildings')->with('message', 'Unidad Habitacional eliminada');
    }

    public function edit(Building $building)
    {
        return view('editBuilding', [
            'building' => $building
        ]);
    }

    public function update(Request $request, Building $building)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
        ]);


        if ($maintenance_budget = $request->get('maintenance_budget')) {
            $formFields = array_merge($formFields, array('maintenance_budget' => $maintenance_budget));

        }

        if ($maintenance_budget_usd = $request->get('maintenance_budget_usd')) {
            $formFields = array_merge($formFields, array('maintenance_budget_usd' => $maintenance_budget_usd));

        }

        try {
            $building->update($formFields);


        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newbuilding')->with('message', $errorInfo);
        }

        return redirect('/buildings')->with('message', 'Unidad Habitacional actualizada');
    }


    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {

        return view('showBuilding', [
            'building' => $building
        ]);
    }

    public function showProperties(Building $building)
    {
        return view('showBuildingProperties', [
            'building' => $building
        ]);
    }


    public function showMaintenanceExpenses(Building $building)
    {
        $now = Carbon::now();

        $myexpensesarray = array();
        foreach ($building->properties as $property) {
            foreach ($property->leases as $lease) {

                $expenses = Expense::where('lease_id', $lease->id)
                    ->where('maintenance_budget', 1)
                    ->whereYear('date', '=', $now->year)
                    ->whereMonth('date', '=', $now->month)
                    ->get();


                foreach ($expenses as $expense) {
                    array_push($myexpensesarray, $expense);
                }
            }

            // Recuperando los egresos sin contrato asociado
            $invoices = Invoice::where("property_id", $property->id)
                ->whereYear('start_date', '=', $now->year)
                ->whereMonth('start_date', '=', $now->month)
                ->get();
            foreach ($invoices as $invoice) {
                foreach ($invoice->expenses as $expense) {
                    if ($expense->maintenance_budget == 1) {
                        array_push($myexpensesarray, $expense);
                    }
                }
            }




        }



        return view('showBuildingMaintenanceExpenses', [
            'building' => $building,
            'expenses' => $myexpensesarray,
            'period' => ' Mes: ' . $now->month . ' / ' . $now->year

        ]);
    }


}