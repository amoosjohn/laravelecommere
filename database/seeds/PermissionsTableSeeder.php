<?php

use Illuminate\Database\Seeder;
use App\Permissions;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
                [
        		'parent_id' => 0,
        		'name' => 'product',
                        'description' => 'Products',
        	],
        	[
        		'parent_id' => 1,
        		'name' => 'product_show',
                        'description' => 'Show',
        	],
        	[
        		'parent_id' => 1,
        		'name' => 'product_create',
                        'description' => 'Create',
        	],
        	[
        		'parent_id' => 1,
        		'name' => 'product_update',
                        'description' => 'Update',
        	],
        	[
        		'parent_id' => 1,
        		'name' => 'product_delete',
                        'description' => 'Delete',
        	],
                [
        		'parent_id' => 1,
        		'name' => 'product_import',
                        'description' => 'Import',
        	],
        	[
        		'parent_id' => 1,
        		'name' => 'product_export',
                        'description' => 'Export',
        	],
                [
        		'parent_id' => 0,
        		'name' => 'commission',
                        'description' => 'Commission Fee',
        	],
                [
        		'parent_id' => 0,
        		'name' => 'orders',
                        'description' => 'Orders',
        	],
                [
        		'parent_id' => 0,
        		'name' => 'monthly_sales',
                        'description' => 'Monthly Sales Chart',
        	],
                [
        		'parent_id' => 0,
        		'name' => 'monthly_orders',
                        'description' => 'Monthly Orders Chart',
        	],
        	
        ];


        foreach ($permission as $key => $value) {
        	Permissions::create($value);
        }
    }
}
