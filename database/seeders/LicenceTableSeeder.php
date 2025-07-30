<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LicenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       /**
         * Run the database seeds.
         */

        DB::connection('mysql')->table('licences')->insert([
            'licence_key' => $this->generateUniqueCode(),
            'expiration_date' => Carbon::now()->addYear(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Generate a unique application code.
     */
    private function generateUniqueCode(): string
    {
        return Str::upper(Str::random(4)) . '-' . Str::upper(Str::random(4)) . '-' . Str::upper(Str::random(4)) . '-' . Str::upper(Str::random(4));
    }
}
