<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;


class TenantController extends Controller
{
    //
    public function index()
    {

        return view('listTenants', [
            'tenants' => Tenant::latest()->get()
            // ->simplePaginate(10)

        ]);
    }


    public function create()
    {

        return view('createTenant');

    }


    //Store Data
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'name' => ['required', Rule::unique('tenants', 'name')],
            'address' => 'required',
            'email' => ['required', 'email'],
            // 'phone' => 'required|numeric|digits:10',
            'phone' => 'required',

            'description' => 'required'

        ]);


        //FROM THE MODEL
        try {
            $tenant = Tenant::create($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newtenant')->with('message', $errorInfo);
        }
        Log::info("Arrendatario Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$tenant->id}) Nombre ({$tenant->name}) Direccion ({$tenant->address}) Email ({$tenant->email}) Phone ({$tenant->phone}) Descripcion ({$tenant->description}) ");

        return redirect('/tenants')->with('message', 'Arrendatario creado');
    }

    public function destroy(Tenant $tenant)
    {
        try {
            $tenant->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/tenants')->with('message', $errorInfo);
        }
        Log::info("Arrendatario Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$tenant->id}) Nombre ({$tenant->name}) Direccion ({$tenant->address}) Email ({$tenant->email}) Phone ({$tenant->phone}) Descripcion ({$tenant->description}) ");

        return redirect('/tenants')->with('message', 'Arrendatario eliminado');

    }

    public function edit(Tenant $tenant)
    {
        return view('editTenant', ['tenant' => $tenant]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        // dd($request->file('logo'));

        $formFields = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required'
        ]);



        //FROM THE MODEL
        try {
            $tenant->update($formFields);
        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('/newtenant')->with('message', $errorInfo);
        }

        Log::info("Arrendatario Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$tenant->id}) Nombre ({$tenant->name}) Direccion ({$tenant->address}) Email ({$tenant->email}) Phone ({$tenant->phone}) Descripcion ({$tenant->description}) ");

        return redirect('/tenants')->with('message', 'Arrendatario actualizado');
    }

    public function show(Tenant $tenant)
    {
        return view('showTenant', [
            'tenant' => $tenant
        ]);
    }

}
