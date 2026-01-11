<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'PT Ositech',
            'email' => 'admin@ositech.com',
            'address' => 'Jakarta',
            'latitude' => '-6.200000',
            'longitude' => '106.816666',
            'radius_km' => '1',
            'time_in' => '08:00',
            'time_out' => '17:00',
            'type' => 'company'
        ]);

        Company::create([
            'name' => 'TPQ Al Hikmah',
            'email' => 'admin@tpq.com',
            'address' => 'Bandung',
            'latitude' => '-6.9',
            'longitude' => '107.6',
            'radius_km' => '1',
            'time_in' => '16:00',
            'time_out' => '18:00',
            'type' => 'pesantren'
        ]);

        Company::create([
            'name' => 'SMA Negeri 1',
            'email' => 'admin@sma1.sch.id',
            'address' => 'Surabaya',
            'latitude' => '-7.2',
            'longitude' => '112.7',
            'radius_km' => '1',
            'time_in' => '07:00',
            'time_out' => '15:00',
            'type' => 'school'
        ]);
    }
}
