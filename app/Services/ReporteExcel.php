<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReporteExcel
{
    public function reportePilares($consulta)
    {
        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();

        $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $cabeceras = [
            'Pilar',
            'Descripción',
            'Cantidad Medidas',
            'Medidas Finalizadas',
            'Cantidad Acciones',
            'Acciones sin iniciar',
            'Acciones en Proceso',
            'Acciones Finalizadas',
        ];
        $anchos = [30, 60, 18, 22, 22, 18, 18, 20];

        foreach ($columnas as $i => $col) {
            $hojaActiva->getColumnDimension($col)->setWidth($anchos[$i]);
            $hojaActiva->getStyle($col)->getAlignment()->setWrapText(true);
        }

        $fecha_hora = date('d/m/Y H:i') . " hrs.";
        $tituloReporte = 'Reporte de Pilares (' . $fecha_hora . ')';
        $hojaActiva->setCellValue('A1', $tituloReporte);
        $hojaActiva->mergeCells('A1:H1');
        $hojaActiva->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 15],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        $filaCabecera = 3;
        foreach ($cabeceras as $i => $titulo) {
            $celda = $columnas[$i] . $filaCabecera;
            $hojaActiva->setCellValue($celda, $titulo);
            $hojaActiva->getStyle($celda)->applyFromArray(['font' => ['bold' => true, 'size' => 12]]);
        }

        $fila = 4;
        foreach ($consulta as $pilar) {
            $hojaActiva->setCellValue("A{$fila}", $pilar->titulo);
            $hojaActiva->setCellValue("B{$fila}", strip_tags($pilar->descripcion));
            $hojaActiva->setCellValue("C{$fila}", $pilar->cantidad_medidas ?? 0);
            $hojaActiva->setCellValue("D{$fila}", $pilar->cantidad_medidas_finalizadas ?? 0);
            $hojaActiva->setCellValue("E{$fila}", $pilar->cantidad_acciones ?? 0);
            $hojaActiva->setCellValue("F{$fila}", $pilar->cantidad_acciones_sin_iniciar ?? 0);
            $hojaActiva->setCellValue("G{$fila}", $pilar->cantidad_acciones_proceso ?? 0);
            $hojaActiva->setCellValue("H{$fila}", $pilar->cantidad_acciones_finalizadas ?? 0);
            $fila++;
        }

        $ultimaFila = $fila - 1;
        $hojaActiva->getStyle("A3:H{$ultimaFila}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '787878'],
                ],
            ],
        ]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Pilares ' . date('d-m-Y - Hi') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reporteMedidas($consulta)
    {

        $excel = new Spreadsheet();
        $hojaMedidas = $excel->getActiveSheet();
        $hojaMedidas->setTitle('Resumen');

        $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        $cabeceras = [
            'Pilar',
            'Medida',
            'Descripción',
            'Cantidad Acciones',
            'Acciones sin iniciar',
            'Acciones en Proceso',
            'Acciones Finalizadas',
        ];
        $anchos = [30, 50, 90, 18, 18, 18, 20];

        foreach ($columnas as $i => $col) {
            $hojaMedidas->getColumnDimension($col)->setWidth($anchos[$i]);
            $hojaMedidas->getStyle($col)->getAlignment()->setWrapText(true);
        }

        $fecha_hora = date('d/m/Y H:i') . " hrs.";
        $tituloReporte = 'Reporte de Medidas (' . $fecha_hora . ')';
        $hojaMedidas->setCellValue('A1', $tituloReporte);
        $hojaMedidas->mergeCells('A1:G1');
        $hojaMedidas->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 15],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        $filaCabecera = 3;
        foreach ($cabeceras as $i => $titulo) {
            $celda = $columnas[$i] . $filaCabecera;
            $hojaMedidas->setCellValue($celda, $titulo);
            $hojaMedidas->getStyle($celda)->applyFromArray(['font' => ['bold' => true, 'size' => 12]]);
        }

        $fila = 4;
        $inicioPilar = $fila;
        $nombreAnterior = null;

        foreach ($consulta as $i => $medida) {
            if ($nombreAnterior !== null && $nombreAnterior !== $medida->nombre_pilar) {
                $finPilar = $fila - 1;
                $hojaMedidas->setCellValue("A{$inicioPilar}", $nombreAnterior);
                $hojaMedidas->mergeCells("A{$inicioPilar}:A{$finPilar}");
                $hojaMedidas->getStyle("A{$inicioPilar}:A{$finPilar}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                    'font' => ['bold' => true]
                ]);
                $fila++;
                $inicioPilar = $fila;
            }

            $hojaMedidas->setCellValue("B{$fila}", $medida->titulo);
            $hojaMedidas->setCellValue("C{$fila}", strip_tags($medida->descripcion));
            $hojaMedidas->setCellValue("D{$fila}", $medida->cantidad_acciones ?? 0);
            $hojaMedidas->setCellValue("E{$fila}", $medida->cantidad_acciones_sin_iniciar ?? 0);
            $hojaMedidas->setCellValue("F{$fila}", $medida->cantidad_acciones_proceso ?? 0);
            $hojaMedidas->setCellValue("G{$fila}", $medida->cantidad_acciones_finalizadas ?? 0);

            $nombreAnterior = $medida->nombre_pilar;

            $fila++;
        }

        if ($fila > $inicioPilar) {
            $finPilar = $fila - 1;
            $hojaMedidas->mergeCells("A{$inicioPilar}:A{$finPilar}");
            $hojaMedidas->setCellValue("A{$inicioPilar}", $nombreAnterior);
            $hojaMedidas->getStyle("A{$inicioPilar}:A{$finPilar}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'D9D9D9'],
                ],
                'font' => ['bold' => true]
            ]);
        }

        $ultimaFila = $fila - 1;
        $hojaMedidas->getStyle("A3:G{$ultimaFila}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '787878'],
                ],
            ],
        ]);

        $hojaAcciones = $excel->createSheet();
        $hojaAcciones->setTitle('Acciones');

        $cabecerasAcciones = [
            'Medida',
            '#',
            'Descripción',
            'Indicador',
            'Periodo',
            'Plazo',
            'Plazo Inicio',
            'Plazo Fin',
            'Fecha Cumplimiento',
            'Medio Verificación',
            'Porcentaje Cumplimiento'
        ];

        $anchosAcciones = [
            'A' => 30,
            'B' => 10,
            'C' => 80,
            'D' => 25,
            'E' => 15,
            'F' => 20,
            'G' => 18,
            'H' => 18,
            'I' => 20,
            'J' => 30,
            'K' => 18
        ];

        foreach ($cabecerasAcciones as $i => $titulo) {
            $col = chr(65 + $i); // A, B, C, ...
            $hojaAcciones->setCellValue("{$col}1", $titulo);
            $hojaAcciones->getStyle("{$col}1")->applyFromArray([
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            $hojaAcciones->getColumnDimension($col)->setWidth($anchosAcciones[$col] ?? 25);
            $hojaAcciones->getStyle($col)->getAlignment()->setWrapText(true);
        }


        $filaAccion = 2;
        foreach ($consulta as $pilar) {
            $acciones = $pilar->acciones ?? collect();

            if ($acciones->isEmpty()) {
                continue;
            }

            $inicioFila = $filaAccion;
            foreach ($acciones as $accion) {
                $hojaAcciones->setCellValue("B{$filaAccion}", $accion->id_propio);
                $hojaAcciones->setCellValue("C{$filaAccion}", strip_tags($accion->descripcion ?? ''));
                $hojaAcciones->setCellValue("D{$filaAccion}", $accion->indicador ?? '');
                $hojaAcciones->setCellValue("E{$filaAccion}", $accion->periodo ?? '');
                $hojaAcciones->setCellValue("F{$filaAccion}", $accion->plazo_txt ?? '');
                $hojaAcciones->setCellValue("G{$filaAccion}", $accion->plazo_inicio ?? '');
                $hojaAcciones->setCellValue("H{$filaAccion}", $accion->plazo_fin ?? '');
                $hojaAcciones->setCellValue("I{$filaAccion}", $accion->fecha_cumplimiento ?? '');
                $hojaAcciones->setCellValue("J{$filaAccion}", $accion->medio_verificacion ?? '');
                $hojaAcciones->setCellValue("K{$filaAccion}", $accion->porcentaje_cumplimiento . '%' ?? '');
                $filaAccion++;
            }

            $finFila = $filaAccion - 1;

            $hojaAcciones->mergeCells("A{$inicioFila}:A{$finFila}");
            $hojaAcciones->setCellValue("A{$inicioFila}", $pilar->titulo);

            $hojaAcciones->getStyle("A{$inicioFila}:A{$finFila}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'D9D9D9'],
                ],
                'font' => ['bold' => true]
            ]);

            $filaAccion += 2;
        }

        $ultimaFilaAccion = $filaAccion - 1;
        $hojaAcciones->getStyle("A1:K{$ultimaFilaAccion}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'AAAAAA'],
                ],
            ],
        ]);

        $ultimaFilaAccion = $filaAccion - 1;

        for ($row = 2; $row <= $ultimaFilaAccion; $row++) {
            $idAccion = $hojaAcciones->getCell("B{$row}")->getValue();
            if (empty($idAccion)) {
                continue;
            }

            $hojaAcciones->getStyle("A{$row}:K{$row}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
        }

        $columnasCentrar = ['B', 'E', 'F', 'G', 'H', 'I', 'K'];

        foreach ($columnasCentrar as $col) {
            $hojaAcciones->getStyle("{$col}2:{$col}{$filaAccion}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Medidas ' . date('d-m-Y - Hi') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reporteAcciones($consulta)
    {
        $excel = new Spreadsheet();

        /** HOJA 1 - ACCIONES **/
        $hojaAcciones = $excel->getActiveSheet();
        $hojaAcciones->setTitle('Acciones');

        $cabeceras = [
            'A' => 'Pilar',
            'B' => 'Medida',
            'C' => 'Acción',
            'D' => 'Indicador',
            'E' => 'Periodo',
            'F' => 'Plazo',
            'G' => 'Inicio',
            'H' => 'Término',
            'I' => 'Fecha Cumplimiento',
            'J' => 'Medio Verificación',
        ];

        $anchosAcciones = [
            'A' => 25,
            'B' => 35,
            'C' => 75,
            'D' => 30,
            'E' => 15,
            'F' => 18,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 70,
        ];

        foreach ($cabeceras as $col => $titulo) {
            $hojaAcciones->setCellValue("{$col}1", $titulo);
            $hojaAcciones->getStyle("{$col}1")->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $hojaAcciones->getColumnDimension($col)->setWidth($anchosAcciones[$col]);
        }

        $fila = 2;
        $grupo = collect($consulta)->groupBy('nombre_pilar');

        foreach ($grupo as $nombrePilar => $accionesPorPilar) {
            $grupoMedidas = $accionesPorPilar->groupBy('nombre_medida');
            $inicioPilar = $fila;

            foreach ($grupoMedidas as $nombreMedida => $accionesPorMedida) {
                $inicioMedida = $fila;

                foreach ($accionesPorMedida as $indice => $accion) {
                    $accionTexto = "{$accion->descripcion}" . " ({$accion->id_propio})";

                    $hojaAcciones->setCellValue("C{$fila}", $accionTexto);
                    $hojaAcciones->setCellValue("D{$fila}", $accion->indicador ?? 'N/A');
                    $hojaAcciones->setCellValue("E{$fila}", $accion->periodo ?? 'N/A');
                    $hojaAcciones->setCellValue("F{$fila}", $accion->plazo_txt ?? 'N/A');
                    $hojaAcciones->setCellValue("G{$fila}", $accion->plazo_inicio ?? '');
                    $hojaAcciones->setCellValue("H{$fila}", $accion->plazo_fin ?? '');
                    $hojaAcciones->setCellValue("I{$fila}", $accion->fecha_cumplimiento ?? 'Pendiente');
                    $hojaAcciones->setCellValue("J{$fila}", $accion->medio_verificacion ?? '');

                    $hojaAcciones->getRowDimension($fila)->setRowHeight(40);
                    $fila++;
                }

                $finMedida = $fila - 1;
                $hojaAcciones->mergeCells("B{$inicioMedida}:B{$finMedida}");
                $hojaAcciones->setCellValue("B{$inicioMedida}", $nombreMedida);
                $hojaAcciones->getStyle("B{$inicioMedida}:B{$finMedida}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                    'font' => ['bold' => true]
                ]);
            }

            $finPilar = $fila - 1;
            $hojaAcciones->mergeCells("A{$inicioPilar}:A{$finPilar}");
            $hojaAcciones->setCellValue("A{$inicioPilar}", $nombrePilar);
            $hojaAcciones->getStyle("A{$inicioPilar}:A{$finPilar}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'C0C0C0'],
                ],
                'font' => ['bold' => true]
            ]);

            $fila++; 
        }

        $hojaAcciones->getStyle("A1:J" . ($fila - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '999999'],
                ],
            ],
        ]);

        /** HOJA 2 - DOCUMENTOS Y COMENTARIOS **/
        $hojaExtra = $excel->createSheet();
        $hojaExtra->setTitle('Documentos y Comentarios');

        $hojaExtra->setCellValue("A1", "Acción");
        $hojaExtra->setCellValue("B1", "Descripción");
        $hojaExtra->setCellValue("C1", "Tipo");
        $hojaExtra->setCellValue("D1", "Usuario");
        $hojaExtra->setCellValue("E1", "Unidad");
        $hojaExtra->setCellValue("F1", "Fecha");

        $anchosExtra = [
            'A' => 55,
            'B' => 60,
            'C' => 18,
            'D' => 35,
            'E' => 25,
            'F' => 20,
        ];

        foreach ($anchosExtra as $col => $ancho) {
            $hojaExtra->getStyle("{$col}1")->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $hojaExtra->getColumnDimension($col)->setWidth($ancho);
        }

        $filaExtra = 2;

        foreach ($consulta as $accion) {
            $mostroAccion = false;
            $inicioFila = $filaExtra;

            $accionTitulo = ($accion->descripcion ?? 'Acción') . ' (' . $accion->id_propio . ')';
            foreach ($accion->documentosComentarios as $item) {
                $esDocumento = $item->tipo === 'archivo';
                $celda = "B{$filaExtra}";

                $hojaExtra->setCellValue("A{$filaExtra}", !$mostroAccion ? $accionTitulo : '');

                if ($esDocumento) {
                    $nombreArchivo = $item->nombre ?? 'Archivo';
                    $url = 'http://127.0.0.1:5000/archivo/' . ($item->token ?? '');

                    $hojaExtra->setCellValue($celda, $nombreArchivo);
                    $hojaExtra->getCell($celda)->getHyperlink()->setUrl($url);
                    $hojaExtra->getStyle($celda)->getFont()->setUnderline(true)->getColor()->setARGB('0000FF');
                    $hojaExtra->setCellValue("C{$filaExtra}", 'Documento');
                } else {
                    $comentarioTexto = strip_tags($item->comentario ?? '');
                    $hojaExtra->setCellValue($celda, $comentarioTexto);
                    $hojaExtra->setCellValue("C{$filaExtra}", 'Comentario');
                }

                $hojaExtra->setCellValue("D{$filaExtra}", $item->nombreUsuario ?? '');
                $hojaExtra->setCellValue("E{$filaExtra}", $item->unidad ?? '');
                $hojaExtra->setCellValue("F{$filaExtra}", $item->created_at ?? '');

                $mostroAccion = true;
                $filaExtra++;
            }


            if ($filaExtra > $inicioFila) {
                $finFila = $filaExtra - 1;

                $hojaExtra->mergeCells("A{$inicioFila}:A{$finFila}");
                $hojaExtra->getStyle("A{$inicioFila}:A{$finFila}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                    'font' => ['bold' => true]
                ]);
                $filaExtra++;
            }
        }

        $hojaExtra->getStyle("A1:F" . ($filaExtra - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '999999'],
                ],
            ],
        ]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Acciones ' . date('d-m-Y - Hi') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
