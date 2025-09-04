<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoNotificacion;

class TipoNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposNotificacion = [
            [
                'id' => 1,
                'nombre' => 'Subvención Creada',
                'mensaje' => 'Se ha creado una nueva subvención que requiere revisión.',
                'estado' => 1
            ],
            [
                'id' => 2,
                'nombre' => 'Rendición Pendiente',
                'mensaje' => 'La rendición está pendiente de revisión.',
                'estado' => 1
            ],
            [
                'id' => 3,
                'nombre' => 'Rendición Aprobada',
                'mensaje' => 'La rendición ha sido aprobada.',
                'estado' => 1
            ],
            [
                'id' => 4,
                'nombre' => 'Rendición Rechazada',
                'mensaje' => 'La rendición ha sido rechazada y requiere correcciones.',
                'estado' => 1
            ],
            [
                'id' => 5,
                'nombre' => 'Recordatorio',
                'mensaje' => 'Recordatorio: La rendición requiere atención.',
                'estado' => 1
            ]
        ];

        foreach ($tiposNotificacion as $tipo) {
            TipoNotificacion::updateOrCreate(
                ['id' => $tipo['id']],
                $tipo
            );
        }
    }
}
