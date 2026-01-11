<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::where('type', 'company')->first();
        $pesantren = Company::where('type', 'pesantren')->first();
        $school = Company::where('type', 'school')->first();

        // COMPANY
        User::create([
            'name' => 'Rudi HR',
            'email' => 'hr@ositech.com',
            'password' => Hash::make('123456'),
            'role' => 'hr',
            'company_id' => $company->id,
            'position' => 'HR Manager'
        ]);

        User::create([
            'name' => 'Budi Employee',
            'email' => 'employee@ositech.com',
            'password' => Hash::make('123456'),
            'role' => 'employee',
            'company_id' => $company->id,
            'position' => 'Staff IT'
        ]);

        // PESANTREN
        User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@tpq.com',
            'password' => Hash::make('123456'),
            'role' => 'ustadz',
            'company_id' => $pesantren->id
        ]);

        User::create([
            'name' => 'Santri Ali',
            'email' => 'santri@tpq.com',
            'password' => Hash::make('123456'),
            'role' => 'santri',
            'company_id' => $pesantren->id
        ]);

        // SCHOOL
        User::create([
            'name' => 'Teacher Siti',
            'email' => 'teacher@sma1.sch.id',
            'password' => Hash::make('123456'),
            'role' => 'teacher',
            'company_id' => $school->id
        ]);

        User::create([
            'name' => 'Student Andi',
            'email' => 'student@sma1.sch.id',
            'password' => Hash::make('123456'),
            'role' => 'student',
            'company_id' => $school->id
        ]);
    }
}
