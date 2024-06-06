<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Building;
use App\Models\Landlord;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\Subproperty;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Decimal;


class DropdownController extends Controller
{
    // public function index()
    // {
    //     $data['leases'] = Lease::get();
    //     return view('dropdown', $data);
    // }



    public function fetchInvoice(Request $request)
    {

        if ($request->category == 'IngresoSimple') {



            $data['invoices'] = Invoice::where("lease_id", $request->lease_id)
                ->where('category', '=', "Ingreso")
                ->get();

            error_log("Caso IngresoSimple");

        } elseif ($request->category == 'EgresoSimple') {
            $data['invoices'] = Invoice::where("lease_id", $request->lease_id)
                ->where('category', '=', "Egreso")
                ->get();
            error_log("Caso Egreso");
            error_log("");
        } elseif ($request->concept == 'Otro') {
            $data['invoices'] = Invoice::where("lease_id", $request->lease_id)
                ->where('concept', '=', "Otro")
                ->get();
            error_log("Caso Otro");

        } elseif ($request->concept == 'ammount') {
            $data['invoices'] = Invoice::where("id", $request->invoice_id)->get();
            error_log("Caso ammount");

        } elseif ($request->concept == 'paid') {

            error_log("Caso paid");
            $myinvoce = Invoice::where("id", $request->invoice_id)->get()->first();
            error_log($myinvoce);
            error_log('infoinside -> ' . $myinvoce->lease->id);


            error_log("saliendo de caso paid");

            return response()->json($myinvoce->type . ' $' . $myinvoce->payments->sum('ammount') . '        # Pagos asociados: ' . count($myinvoce->payments));


        } elseif ($request->concept == 'tobepaid') {

            error_log("Caso tobepaid");
            $myinvoce = Invoice::where("id", $request->invoice_id)->get()->first();


            return response()->json($myinvoce->type . ' $' . $myinvoce->balance);


        } elseif ($request->concept == 'paid-expense') {

            error_log("Caso paid-expense");
            $myinvoce = Invoice::where("id", $request->invoice_id)->get()->first();
            error_log($myinvoce);
            error_log('infoinside -> ' . $myinvoce->lease->id);



            if (count($myinvoce->expenses) > 0) {
                return response()->json($myinvoce->type . ' $' . $myinvoce->expenses->sum('ammount') . '        ### Pagos asociados: ' . count($myinvoce->expenses) . '               Proveedor: ' . $myinvoce->expenses->first()->supplier->name);
            } else {
                return response()->json($myinvoce->type . ' $0     Sin pagos asociados');
            }



        } elseif ($request->concept == 'tobepaid-expense') {
            error_log("Caso tobepaid-expense");

            $myinvoce = Invoice::where("id", $request->invoice_id)->get()->first();

            return response()->json($myinvoce->type . ' $' . $myinvoce->balance);


        } elseif ($request->concept == 'type') {

            error_log("Caso type");
            $invoceType = Invoice::where("id", $request->invoice_id)->get()->first()->type;
            if ($invoceType == $request->type) {
                error_log(" es igual");

                return response()->json('equal');


            } else {
                error_log(" es diferente");

                return response()->json('notequal');


            }



        } elseif ($request->concept == 'propertyhasbuilding') {

            error_log("Caso property_has_building");
            $invoceType = Invoice::where("id", $request->invoice_id)->get()->first()->type;
            if ($request->lease_id == 1) {
                if ($mysubprop_id = Invoice::whereid($request->invoice_id)->get()->first()->subproperty_id) {
                    return response()->json('--');
                }
                if ($myprop_id = Invoice::whereid($request->invoice_id)->get()->first()->property_id) {
                    $mybuilding = Property::whereid($myprop_id)->first()->building;
                    error_log("sub caso Subproperty");

                    if ($mybuilding->id == 1) {
                        return response()->json('--');
                    } else {
                        error_log($mybuilding->name);
                        return response()->json($mybuilding->name . ' | Presupuesto de Mantenimiento (MXN): ' . Number::currency($mybuilding->maintenance_budget) . ' | Presupuesto de Mantenimiento (USD): ' . Number::currency($mybuilding->maintenance_budget_usd));
                    }

                }

            } else {

                $mylease = Lease::whereid($request->lease_id)->first();
                if ($mylease->subproperty_id != 1) {
                    return response()->json('--');
                } else {

                    if ($myprop = Lease::whereid($request->lease_id)->first()->property_) {

                        if ($myprop->building->id == 1) {
                            return response()->json('--');
                        } else {
                            error_log($myprop->building->name);
                            return response()->json($myprop->building->name . ' | Presupuesto de Mantenimiento (MXN): ' . Number::currency($myprop->building->maintenance_budget) . ' | Presupuesto de Mantenimiento (USD): ' . Number::currency($myprop->building->maintenance_budget_usd));

                        }
                    } else {
                        return response()->json('--');
                    }
                }






            }



        } elseif ($request->concept == 'accounts') {

            error_log("Caso accounts");
            $mylease = Lease::where("id", $request->lease_id)->first();

            if ($request->lease_id == 1) {
                $data['accounts'] = Account::all();

            } else {
                if ($mylease->subproperty_id != 1) {
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $mylease->subproperty->landlord_id)
                        ->get();
                } else {
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $mylease->property_->landlord_id)
                        ->get();
                }


            }




        } elseif ($request->concept == 'accounts_expense') {

            error_log("Caso accounts_expense");



            if ($request->lease_id == 1) {
                if ($myprop_id = Invoice::whereid($request->invoice_id)->first()->property_id) {
                    $myLandlordId = Property::whereid($myprop_id)->first()->landlord_id;
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $myLandlordId)
                        ->get();
                }
                if ($mysubprop_id = Invoice::whereId($request->invoice_id)->first()->subproperty_id) {
                    $myLandlordId = Subproperty::whereid($mysubprop_id)->first()->landlord_id;
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $myLandlordId)
                        ->get();
                }


            } else {
                $mylease = Lease::where("id", $request->lease_id)->first();

                if ($mylease->subproperty_id != 1) {
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $mylease->subproperty->landlord_id)
                        ->get();
                } else {
                    $data['accounts'] = Account::where("type", $request->type)
                        ->where('landlord_id', $mylease->property_->landlord_id)
                        ->get();
                }

            }




        } elseif ($request->concept == 'leases') {

            error_log("Caso leases .. ");
            if ($request->category == 'Ingreso General') {
                $data['leases'] = Lease::where("id", "!=", 1)
                    ->get();
                // $data['leases'] = Lease::all();

            } else {
                $data['leases'] = Lease::all();

            }

            error_log(json_encode($data));



        } elseif ($request->concept == 'property-nolease') {

            error_log("Caso property-nolease");

            $invoiceProperty_id = Invoice::where("id", $request->invoice_id)->get()->first()->property_id;
            $invoiceSubproperty_id = Invoice::where("id", $request->invoice_id)->get()->first()->subproperty_id;
            $invoiceBuilding_id = Invoice::where("id", $request->invoice_id)->get()->first()->building_id;

            if ($myproperty = Property::whereid($invoiceProperty_id)->get()->first()) {
                return response()->json('Unidad: ' . $myproperty->title . '  /  Propietario: ' . $myproperty->Landlord->name);
            } elseif ($mysubproperty = Subproperty::whereid($invoiceSubproperty_id)->get()->first()) {
                return response()->json('Subunidad: ' . $mysubproperty->title . '  /  Propietario: ' . $mysubproperty->Landlord->name);
            } elseif ($mybuilding = Building::whereid($invoiceBuilding_id)->get()->first()) {
                return response()->json('Edificio: ' . $mybuilding->name);
            }
            // return response()->json($invoiceProperty_id);

        } elseif ($request->concept == 'find_building_address') {
            error_log("Caso find_building_address");

            $mybuilding_address = Building::whereid($request->building_id)->get()->first()->address;
            error_log($mybuilding_address);
            return response()->json($mybuilding_address);

        } elseif ($request->concept == 'find_property_location') {
            error_log("Caso find_property_location");

            $myproperty_address = Property::whereid($request->property_id)->get()->first()->location;
            error_log($myproperty_address);
            return response()->json($myproperty_address);

        } elseif ($request->concept == 'find_property_landlord') {
            error_log("Caso find_property_landlord");
            $myproperty = Property::whereid($request->property_id)->get()->first();
            if ($myproperty->id == 1) {
                $data['landlords'] = Landlord::all();
            } else {
                $data['landlords'] = [$myproperty->landlord];
            }


        } elseif ($request->concept == 'find_supplier') {
            error_log("Caso find_supplier");


            $myinvoice = Invoice::whereid($request->invoice_id)->get()->first();
            // si ya hay pagos se toma el proveedor, sino se regresan todos los proveedores
            if (count($myinvoice->expenses) > 0) {
                $data['suppliers'] = Supplier::whereid($myinvoice->expenses->first()->supplier_id)
                    ->get();
                // $data['suppliers'] = Supplier::all();

            } else {
                $data['suppliers'] = Supplier::all();
            }




        } else {
            error_log($request->concept);
            error_log("Caso else");

        }


        error_log('Saliendo....');

        error_log(json_encode($data));

        return response()->json($data);
    }


    public function fetchSubproperties(Request $request)
    {
        error_log("fetchSubproperties");

        $data['subproperties'] = Subproperty::where("property_id", $request->property_id)
            ->get();
        // Falta implementar logica para no listar subpropiedades ya rentadas


        error_log(json_encode($data));

        return response()->json($data);
    }



}
