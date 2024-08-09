<?php

namespace Database\Seeders;

use App\Models\AdditionalExpenseAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalExpenseAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (AdditionalExpenseAccount::count()) {
            AdditionalExpenseAccount::truncate();
        }

        $data = [
            ['account_number' => 9900617001, 'account_name' => 'COSTO MOVIMIENTOS AUTOS'],
            ['account_number' => 9900617002, 'account_name' => 'COSTO PAPEL AHUMADO'],
            ['account_number' => 9900617003, 'account_name' => 'COSTO COMBUSTIBLE AUTOS NUEVOS'],
            ['account_number' => 9900617004, 'account_name' => 'COSTO REFRENDO DE DOCUMENTOS'],
            ['account_number' => 9900617005, 'account_name' => 'COSTO REPARACIONES Y PULIMIENTOS'],
        ];

        foreach ($data as $account) {
            AdditionalExpenseAccount::create($account);
        }
    }
}
