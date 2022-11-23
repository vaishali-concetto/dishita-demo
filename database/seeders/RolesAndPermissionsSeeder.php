<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // create permissions
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'customer_dashboard']);
        Permission::create(['name' => 'seller_dashboard']);
        Permission::create(['name' => 'add category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'add brand']);
        Permission::create(['name' => 'edit brand']);
        Permission::create(['name' => 'delete brand']);
        Permission::create(['name' => 'view brand']);
        Permission::create(['name' => 'add product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'view product']);

        // create roles and assign created permissions
        // this can be done as separate statements
        $role = Role::create([
            'name' => 'admin',
        ]);
        $role->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'customer',
        ]);
        $role->givePermissionTo('customer_dashboard');

        $role = Role::create([
            'name' => 'seller',
        ]);
        $role->givePermissionTo('seller_dashboard');
        $role->givePermissionTo('add category');
        $role->givePermissionTo('edit category');
        $role->givePermissionTo('delete category');
        $role->givePermissionTo('view category');
        $role->givePermissionTo('add brand');
        $role->givePermissionTo('edit brand');
        $role->givePermissionTo('delete brand');
        $role->givePermissionTo('view brand');
        $role->givePermissionTo('add product');
        $role->givePermissionTo('edit product');
        $role->givePermissionTo('delete product');
        $role->givePermissionTo('view product');
    }
}
