<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoRendicion;

class EstadoRendicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadosRendicion = [
            [
                'id' => 1,
                'nombre' => 'Pendiente',
                'estado' => 1
            ],
            [
                'id' => 2,
                'nombre' => 'En Revisión',
                'estado' => 1
            ],
            [
                'id' => 3,
                'nombre' => 'Aprobada',
                'estado' => 1
            ],
            [
                'id' => 4,
                'nombre' => 'Rechazada',
                'estado' => 1
            ],
            [
                'id' => 5,
                'nombre' => 'Completada',
                'estado' => 1
            ]
        ];

        foreach ($estadosRendicion as $estado) {
            EstadoRendicion::updateOrCreate(
                ['id' => $estado['id']],
                $estado
            );
        }
    }
}
