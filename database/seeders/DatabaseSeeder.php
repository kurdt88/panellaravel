<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);

        \App\Models\Landlord::factory()->create([
            'name' => 'Sin Propietario Asociado',
            'email' => '',
            'address' => '',
            'phone' => '',
            'comment' => '',
        ]);


        // NOTA: Debido a que pueden existir propiedades sin una unidad habitacional, se
        // debe crear un objeto unidad habitacional con el ID 1 para referenciar los casos base
        \App\Models\Building::factory()->create([
            'name' => 'Sin Unidad Habitacional Asociada',
            'address' => '',
            'description' => ''
        ]);



        // NOTA: Debido a que no pueden existir propiedades ni subpropiedades sin un landlord, se
        // debe crear un objeto landlord con el ID 1 para referenciar los casos base

        // NOTA:Mismo caso que el anterior, pero con subunidades y propiedades
        \App\Models\Property::factory()->create([
            'title' => 'Sin Propiedad Asociada',
            'rent' => 0,
            'landlord_id' => 1,
            'building_id' => 1,
            // 'tags' => '',
            'location' => '',
            // 'website' => '',
            'description' => ''
        ]);
        // NOTA:Mismo caso que el anterior, pero con subunidades
        \App\Models\Subproperty::factory()->create([
            'title' => 'Sin Subpropiedad Asociada',
            'rent' => 0,
            'landlord_id' => 1,
            'property_id' => 1,

            'type' => '',
            'address' => '',
            'description' => ''
        ]);

        \App\Models\Tenant::factory()->create([
            'name' => 'Sin Arrendatario Asociado',
            'email' => '',
            'address' => '',
            'phone' => '',
            'description' => '',
        ]);


        \App\Models\Lease::factory()->create([
            'contract' => 'Sin Contrato Asociado',
            'property' => 1,
            'tenant' => 1,
            'subproperty_id' => 1,
            'rent' => 0,
            'type' => ''
        ]);



        // NOTA:Mismo caso que el anterior, pero con subunidades
        \App\Models\Supplier::factory()->create([
            'name' => 'Sin Proveedor Asociado',
            'comment' => 'Sin Proveedor Asociado'
        ]);

        \App\Models\Tax::factory()->create([
            'name' => 'Exento',
            'value' => 0,
        ]);

        \App\Models\Tax::factory()->create([
            'name' => 'IVA',
            'value' => 0.16,
        ]);


        \App\Models\Tax::factory()->create([
            'name' => 'IVA_RETENCIONES',
            'value' => -1,
        ]);






        \App\Models\User::factory()->create([
            'name' => 'Recovery Account',
            'email' => 'recovery@live.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('administrador');




        \App\Models\User::factory()->create([
            'name' => 'administrador',
            'email' => 'administrador@live.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('administrador');
        \App\Models\User::factory()->create([
            'name' => 'operador',
            'email' => 'operador@live.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('operador');
        \App\Models\User::factory()->create([
            'name' => 'auditor',
            'email' => 'auditor@live.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('auditor');
        \App\Models\User::factory()->create([
            'name' => 'newuser',
            'email' => 'newuser@live.com',
            'password' => bcrypt('12345678'),
        ]);





        // SEEDER SOLO PARA PROPOSITOS DE DESARROLLO

        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Landlord::factory()->create([
                'name' => 'Propietario ' . $i + 1,
                'email' => 'propietario' . $i + 1 . '@correo.com',
                'address' => 'Direccion ' . $i + 1,
                'phone' => '55443311' . $i + 1,
                'comment' => 'Propietario ' . $i + 1,
            ]);
        }
        for ($i = 2; $i <= 6; $i++) {
            \App\Models\Account::factory()->create([
                'landlord_id' => $i,
                'bank' => 'Banorte',
                'number' => '00012255443311 ' . $i,
                'type' => 'MXN',
                'alias' => 'MXN ' . $i,
                'comment' => 'MXN ' . $i,
            ]);
        }

        for ($i = 2; $i <= 6; $i++) {
            \App\Models\Account::factory()->create([
                'landlord_id' => $i,
                'bank' => 'Scotiabank',
                'number' => '00012227641311 ' . $i,
                'type' => 'USD',
                'alias' => 'USD ' . $i,
                'comment' => 'USD ' . $i,
            ]);
        }


        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Building::factory()->create([
                'name' => 'Unidad Habitacional ' . $i + 1,
                'address' => 'Domicilio ' . $i + 1,
                'description' => 'Unidad Habitacional ' . $i + 1,
            ]);
        }


        for ($i = 2; $i <= 6; $i++) {
            \App\Models\Property::factory()->create([
                'title' => 'Propiedad ' . $i,
                'rent' => 15000,
                'landlord_id' => $i,
                'building_id' => $i,
                'location' => 'Domicilio ' . $i,
                'description' => 'Propiedad ' . $i,
            ]);
        }

        for ($i = 2; $i <= 6; $i++) {
            \App\Models\Subproperty::factory()->create([
                'title' => 'Subpropiedad ' . $i,
                'rent' => 1500,
                'landlord_id' => $i,
                'property_id' => 1,

                'type' => 'Estacionamiento',
                'address' => 'Domicilio ' . $i,
                'description' => 'Subpropiedad ' . $i,
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Tenant::factory()->create([
                'name' => 'Arrendatario ' . $i + 1,
                'email' => 'arrendatario' . $i + 1 . '@correo.com',
                'address' => 'Domicilio ' . $i + 1,
                'phone' => '55443311' . $i + 1,
                'description' => 'Arrendatario ' . $i + 1,
            ]);
        }

        \App\Models\Supplier::factory()->create([
            'name' => 'Proveedor ' . $i,
            'phone' => '55443311' . $i,
            'email' => 'supplier' . $i . '@correo.com',
            'comment' => 'Proveedor ' . $i,
        ]);





    }
}
