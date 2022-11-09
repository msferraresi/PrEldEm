<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeFile;

class TypeFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeFile::create(['name'=>'Documentacion Legal']);
        TypeFile::create(['name'=>'Documentacion Medica']);
        TypeFile::create(['name'=>'Documentacion Educacion']);

        TypeFile::create(['name'=>'Otra documentacion']);
        TypeFile::create(['name'=>'Sabana de recibos']);
    }
}
