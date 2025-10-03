<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubvencionResource;
use App\Http\Resources\AccionResource;
use App\Http\Resources\EstadoRendicionResource;

class RendicionResource extends JsonResource
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
            'subvencion' => new SubvencionResource($this->whenLoaded('subvencion')),
            'estado_rendicion' => new EstadoRendicionResource($this->whenLoaded('estadoRendicion')),
            'acciones' => AccionResource::collection($this->whenLoaded('acciones')),
            'estado' => $this->estado
        ];
    }
}
