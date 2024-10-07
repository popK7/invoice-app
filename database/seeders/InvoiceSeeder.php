<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoicePaymentDetails;
use App\Models\InvoiceProducts;
use Faker\Factory as faker;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 5) as $item) {
            $faker = faker::create();
            $client_id = $faker->randomElement([3,4,5,6,7]);

            $invoice = DB::table('invoice')->insertGetId([
                'client_id' => $client_id,
                'invoice_number'  => '#INV-' . rand(10000000, 90000000),
                'date' => date('Y-m-d'),
                'payment_status' => 0,
                'company_id' => 1,
                'billing_full_name' => 'ABC',
                'billing_address'   => $faker->address,
                'billing_mobile_number' => 9876543110,
                'billing_tax_number' => 'GST-'.rand(100000,90000),
                'shippling_full_name' => 'ABC',
                'shippling_address' => $faker->address,
                'shippling_mobile_number' => 9876543110,
                'shippling_tax_number' => '',
                'is_billing_shippling_add_same' => 0,
                'sub_total' => 1000.00,
                'tax' => 162.00,
                'discount' => 100.00,
                'shipping_charge' => 5.00,
                'total_amount' => 1067.00,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('invoice_products')->insert([
                'invoice_id' => $invoice,
                'product_id' => 1,
                'currency_type' => '$',
                'rate' => 1000.00,
                'quantity' => 1,
                'amount' => 1000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $faker = faker::create();
        $invoice = DB::table('invoice')->insertGetId([
            'client_id' => 3,
            'invoice_number'  => '#INV-' . rand(10000000, 90000000),
            'date' => date('Y-m-d'),
            'payment_status' => 1,
            'company_id' => 1,
            'billing_full_name' => 'ABC',
            'billing_address'   => $faker->address,
            'billing_mobile_number' => 9876543110,
            'billing_tax_number' => 'GST-'.rand(100000,90000),
            'shippling_full_name' => 'ABC',
            'shippling_address' => $faker->address,
            'shippling_mobile_number' => 9876543110,
            'shippling_tax_number' => '',
            'is_billing_shippling_add_same' => 0,
            'sub_total' => 1000.00,
            'tax' => 162.00,
            'discount' => 100.00,
            'shipping_charge' => 5.00,
            'total_amount' => 1067.00,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('invoice_products')->insert([
            'invoice_id' => $invoice,
            'product_id' => 1,
            'currency_type' => '$',
            'rate' => 1000.00,
            'quantity' => 1,
            'amount' => 1000.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('invoice_payment_details')->insert([
            'invoice_id' => $invoice,
            'order_id' => '#INV-5-367581676525556',
            'payment_gateway' => 1,
            'payment_method' => 'Card',
            'card_holder_name' => 'test card',
            'amount' => 1067.00,
            'amount_pay_currency' => 'USD',
            'refund_amount' => NULL,
            'stripe_charge_id' => 'ch_3Mc04nSGWeR7PC0R0xnh5l91',
            'stripe_refund_id' => '',
            'stripe_transaction_id' => 'txn_3Mc04nSGWeR7PC0R0YdaUHdE',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
