<?php
require '../../vendor/autoload.php'; // Asegúrate de que la ruta es correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sistema-asistencia");

// Verificar conexión
if ($conexion->connect_error) {
    die("La conexión ha fallado: " . $conexion->connect_error);
}

// Consulta a la base de datos
$sql = "SELECT asistencia.entrada, asistencia.salida, 
               asistencia.`1Descanso_inicio`, asistencia.`1Descanso_fin`, 
               asistencia.`2Descanso_inicio`, asistencia.`2Descanso_fin`, 
               asistencia.Almuerzo_inicio, asistencia.Almuerzo_fin,
               asistencia.bano, 
               empleado.nombre, empleado.apellido, empleado.dni, cargo.nombre as 'nomCargo' 
        FROM asistencia
        INNER JOIN empleado ON asistencia.id_empleado = empleado.id_empleado
        INNER JOIN cargo ON empleado.cargo = cargo.id_cargo";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados de la tabla
    $headers = [
        'A1' => 'ASESOR',
        'B1' => 'DNI',
        'C1' => 'CARGO',
        'D1' => 'FECHA ENTRADA',
        'E1' => 'HORA ENTRADA',
        'F1' => '1 BREAK INICIO',
        'G1' => '1 BREAK FIN',
        'H1' => '2 BREAK INICIO',
        'I1' => '2 BREAK FIN',
        'J1' => 'ALMUERZO INICIO',
        'K1' => 'ALMUERZO FIN',
        'L1' => 'BAÑO',
        'M1' => 'FECHA SALIDA',
        'N1' => 'HORA SALIDA'
    ];
    
    foreach ($headers as $cell => $header) {
        $sheet->setCellValue($cell, $header);
    }

    // Estilo para los encabezados
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => Color::COLOR_WHITE],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => Color::COLOR_DARKBLUE]
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];

    $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

    // Estilo para las celdas de datos
    $dataStyle = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ];

    // Datos de la tabla
    $row = 2;
    while ($datos = $result->fetch_assoc()) {
        $fechaEntrada = '';
        $horaEntrada = '';
        if (!empty($datos['entrada'])) {
            $fechaHoraEntrada = explode(' ', $datos['entrada']);
            $fechaEntrada = $fechaHoraEntrada[0];
            $horaEntrada = $fechaHoraEntrada[1];
        }

        $fechaSalida = '';
        $horaSalida = '';
        if (!empty($datos['salida'])) {
            $fechaHoraSalida = explode(' ', $datos['salida']);
            $fechaSalida = $fechaHoraSalida[0];
            $horaSalida = $fechaHoraSalida[1];
        }

        $sheet->setCellValue('A' . $row, $datos['nombre'] . " " . $datos['apellido']);
        $sheet->setCellValue('B' . $row, $datos['dni']);
        $sheet->setCellValue('C' . $row, $datos['nomCargo']);
        $sheet->setCellValue('D' . $row, $fechaEntrada);
        $sheet->setCellValue('E' . $row, $horaEntrada);
        $sheet->setCellValue('F' . $row, $datos['1Descanso_inicio']);
        $sheet->setCellValue('G' . $row, $datos['1Descanso_fin']);
        $sheet->setCellValue('H' . $row, $datos['2Descanso_inicio']);
        $sheet->setCellValue('I' . $row, $datos['2Descanso_fin']);
        $sheet->setCellValue('J' . $row, $datos['Almuerzo_inicio']);
        $sheet->setCellValue('K' . $row, $datos['Almuerzo_fin']);
        $sheet->setCellValue('L' . $row, $datos['bano']);
        $sheet->setCellValue('M' . $row, $fechaSalida);
        $sheet->setCellValue('N' . $row, $horaSalida);
        $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray($dataStyle);
        $row++;
    }

    // Autoajustar ancho de columnas
    foreach (range('A', 'N') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Crear el archivo Excel
    $writer = new Xlsx($spreadsheet);
    $filename = 'reporte_asistencia.xlsx';

    // Enviar el archivo al navegador para descargar
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
} else {
    echo "No hay datos para exportar";
}

$conexion->close();
?>