<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypePaycheck;

class TypePaycheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypePaycheck::create(['name'=>'Recibo de Sueldo']);
        TypePaycheck::create(['name'=>'Horas Extras']);
        TypePaycheck::create(['name'=>'SAC']);
        TypePaycheck::create(['name'=>'Vacaciones']);
    }
}
