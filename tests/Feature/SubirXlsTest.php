<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class SubirXlsTest extends TestCase
{
    public function test_registro_exitoso_de_subvenciones(): void
    {
        $name = 'Subvenciones Decreto 2025-458.xlsx';
        $path = Storage::path($name);

        $xls = new UploadedFile($path, $name, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
        $response = $this->post('/subvenciones/crear', [
            'fecha_decreto'=>'2024-05-05',
            'decreto'=>'444-2025',
            'seleccionar_archivo'=>$xls
        ]);


        $response->assertJson([
            'success'=>true,
            'message'=>'Subvenciones registradas con éxito'
        ]);
    }

    public function test_extension_de_archivo_incorrecta(){

    }
}
