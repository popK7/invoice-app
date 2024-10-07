<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Administrator',
                'slug'       => 'admin',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Accountant',
                'slug'       => 'accountant',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Client',
                'slug'       => 'client',
            ]);

        // admin permission add
        $role_admin = Sentinel::findRoleBySlug('admin');
        $role_admin->permissions = [
            'admin.dashboard' => true,

            'invoice.list' => true,
            'invoice.add' => true,
            'invoice.edit' => true,
            'invoice.delete' => true,
            'invoice.view' => true,

            'payment.list' => true,
            'payment.add' => true,
            'payment.edit' => true,
            'payment.delete' => true,
            'payment.view' => true,

            'tax.list' => true,
            'tax.add' => true,
            'tax.edit' => true,
            'tax.delete' => true,
            'tax.status' => true,

            'product.list' => true,
            'product.add' => true,
            'product.edit' => true,
            'product.delete' => true,
            'product.view' => true,

            'report.list' => true,
            'report.add' => true,
            'report.edit' => true,
            'report.delete' => true,
            'report.view' => true,

            'client.list' => true,
            'client.add' => true,
            'client.edit' => true,
            'client.delete' => true,
            'client.view' => true,

            'accountant.list' => true,
            'accountant.add' => true,
            'accountant.edit' => true,
            'accountant.delete' => true,
            'accountant.view' => true,

            'permission.edit' => true,
            'permission.view' => true,

            'brand.list' => true,
            'brand.add' => true,
            'brand.edit' => true,
            'brand.delete' => true,
            'brand.view' => true,

            'category.list' => true,
            'category.add' => true,
            'category.edit' => true,
            'category.delete' => true,
            'category.view' => true,

            'color.list' => true,
            'color.add' => true,
            'color.edit' => true,
            'color.delete' => true,
            'color.view' => true,

            'company.list' => true,
            'company.add' => true,
            'company.edit' => true,
            'company.delete' => true,
            'company.view' => true,

            'setting.update' => true,
        ];
        $role_admin->save();

        // accountant permission add
        $role_accountant = Sentinel::findRoleBySlug('accountant');
        $role_accountant->permissions = [
            'admin.dashboard' => true,

            'invoice.list' => true,
            'invoice.add' => true,
            'invoice.edit' => true,
            'invoice.delete' => true,
            'invoice.view' => true,

            'payment.list' => true,
            'payment.add' => true,
            'payment.edit' => true,
            'payment.delete' => true,
            'payment.view' => true,

            'tax.list' => true,
            'tax.add' => true,
            'tax.edit' => true,
            'tax.delete' => true,
            'tax.status' => true,

            'product.list' => true,
            'product.add' => true,
            'product.edit' => true,
            'product.delete' => true,
            'product.view' => true,

            'report.list' => true,
            'report.add' => true,
            'report.edit' => true,
            'report.delete' => true,
            'report.view' => true,

            'client.list' => true,
            'client.add' => true,
            'client.edit' => true,
            'client.delete' => true,
            'client.view' => true,

            'brand.list' => true,
            'brand.add' => true,
            'brand.edit' => true,
            'brand.delete' => true,
            'brand.view' => true,

            'category.list' => true,
            'category.add' => true,
            'category.edit' => true,
            'category.delete' => true,
            'category.view' => true,

            'color.list' => true,
            'color.add' => true,
            'color.edit' => true,
            'color.delete' => true,
            'color.view' => true,

            'company.list' => true,
            'company.add' => true,
            'company.edit' => true,
            'company.delete' => true,
            'company.view' => true,

            'setting.update' => true,
        ];
        $role_accountant->save();

        // client permission add
        $role_client = Sentinel::findRoleBySlug('client');
        $role_client->permissions = [
            'client_invoice.list' => true,
            'invoice.view' => true,
            'invoice.payment' => true,
        ];
        $role_client->save();
    }
}
