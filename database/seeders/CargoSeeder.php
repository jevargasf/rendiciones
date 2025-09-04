<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            [
                'id' => 1,
                'nombre' => 'Presidente',
                'estado' => 1
            ],
            [
                'id' => 2,
                'nombre' => 'Tesorero(a)',
                'estado' => 1
            ],
            [
                'id' => 3,
                'nombre' => 'Secretario(a)',
                'estado' => 1
            ],
            [
                'id' => 4,
                'nombre' => 'Integrante',
                'estado' => 1
            ]
        ];

        foreach ($cargos as $cargo) {
            Cargo::updateOrCreate(
                ['id' => $cargo['id']],
                $cargo
            );
        }
    }
}
