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
            'name' => 'Luis Perez',
            'email' => 'lperezpaz@live.com',
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


        // \App\Models\Landlord::factory(3)->create();

        // \App\Models\Account::factory(15)->create();


        // \App\Models\Building::factory(5)->create();
        // \App\Models\Property::factory(12)->create();
        // \App\Models\Subproperty::factory(8)->create();

        // \App\Models\Tenant::factory(12)->create();
        // \App\Models\Supplier::factory(4)->create();




    }
}
