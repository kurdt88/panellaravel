<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Landlord;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class PropertyController extends Controller
{

    public function create()
    {

        return view('createproperty', [
            'buildings' => Building::all(),
            'landlords' => Landlord::all()
        ]);
    }

    //Store Data
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => ['required', Rule::unique('properties', 'title')],
            'landlord_id' => 'required',
            'building_id' => 'required',
            'location' => 'required',
            // 'website' => 'required',
            // 'tags' => 'required',
            'rent' => 'required',
            'description' => 'required'
        ]);



        try {
            Property::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/newproperty')->with('message', $errorInfo);
        }

        return redirect('/properties')->with('message', 'Unidad creada');
    }

    public function index()
    {

        return view('listproperties', [
            'properties' => Property::latest()->get()
        ]);
    }


    public function showCommodities(Property $property)
    {


        $myinvoicesarray = array();
        #Aqui recupero las compras de Inventario que se hicieron CON un contrato asociado
        foreach ($property->leases as $lease) {
            $invoices = Invoice::where("lease_id", $lease->id)
                ->where('concept', 'like', '%Compra de Inventario%')
                ->get();


            foreach ($invoices as $invoice) {
                array_push($myinvoicesarray, $invoice);
            }
        }

        #Aqui recupero las compras de Inventario que se hicieron SIN un contrato asociado
        if (
            $myinvoicesnolease = Invoice::where("property_id", $property->id)
                ->where('concept', 'like', '%Compra de Inventario%')
                ->get()
        ) {
            foreach ($myinvoicesnolease as $invoice) {
                array_push($myinvoicesarray, $invoice);
            }
        }


        // dd(json_encode($myinvoicesarray));

        // dd($myinvoicesarray);
        return view('listCommodities', [
            'invoices' => $myinvoicesarray,
            'property' => $property
        ]);

    }


    public function destroy(Property $property)
    {
        try {
            $property->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/properties')->with('message', $errorInfo);
        }
        return redirect('/properties')->with('message', 'Unidad eliminada');

    }

    public function edit(Property $property)
    {
        return view('editProperty', [
            'buildings' => Building::all(),
            'landlords' => Landlord::all(),
            'property' => $property
        ]);
    }


    public function update(Request $request, Property $property)
    {
        // dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => 'required',
            'location' => 'required',
            'landlord_id' => 'required',
            'building_id' => 'required',
            // 'website' => 'required',
            // 'tags' => 'required',
            'rent' => 'required',
            'description' => 'required'
        ]);



        try {
            $property->update($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('/newproperty')->with('message', $errorInfo);
        }

        return redirect('/properties')->with('message', 'Unidad actualizada');
    }

    public function show(Property $property)
    {
        return view('showProperty', [
            'leases' => Lease::latest()->get(),
            'tenants' => Tenant::latest()->get(),
            'property' => $property
        ]);
    }

    public function showSubproperties(Property $property)
    {
        return view('showPropertySubproperties', [
            'property' => $property
        ]);
    }


}
