<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PersonaResource;
use App\Http\Resources\CargoResource;
use App\Http\Resources\NotificacionResource;

class AccionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'comentario' => $this->comentario,
            'estado_rendicion' => $this->estado_rendicion,
            'km_rut' => $this->km_rut,
            'km_nombre' => $this->km_nombre,
            'rendicion_id' => $this->rendicion_id,
            'persona' => new PersonaResource($this->whenLoaded('persona')),
            'cargo' => new CargoResource($this->whenLoaded('cargo')),
            'estado' => $this->estado,
            'notificacion' => $this->when(
                $this->notificacion != null,
                new NotificacionResource($this->notificacion)
            )
        ];
    }
}
