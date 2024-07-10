<?php
// Incluir las librerías necesarias
require '../../vendor/autoload.php';
include '../../modelo/conexion.php';

// Crear una nueva instancia de PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los encabezados de la hoja de cálculo
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Asesor');
$sheet->setCellValue('C1', 'Cargo');
$sheet->setCellValue('D1', 'Entrada');
$sheet->setCellValue('E1', '1BREAK_inicio');
$sheet->setCellValue('F1', '1BREAK_fin');
$sheet->setCellValue('G1', '2BREAK_inicio');
$sheet->setCellValue('H1', '2BREAK_fin');
$sheet->setCellValue('I1', 'ALMUERZO_INICIO');
$sheet->setCellValue('J1', 'ALMUERZO_FIN');
$sheet->setCellValue('K1', 'INICIO BAÑO');
$sheet->setCellValue('L1', 'BAÑO');
$sheet->setCellValue('M1', 'SALIDA');

// Aplicar estilo para los encabezados (usar el mismo estilo que en export_excel.php)
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

$sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

// Obtener la fecha de hoy
$fechaHoy = date('Y-m-d');

// Consultar los datos de la asistencia del día actual
$sql = $conexion->query("SELECT
    asistencia.id_asistencia, 
    CONCAT(empleado.nombre, ' ', empleado.apellido) as asesor, 
    cargo.nombre as cargo, 
    asistencia.entrada, 
    asistencia.1Descanso_inicio, 
    asistencia.1Descanso_fin, 
    asistencia.2Descanso_inicio, 
    asistencia.2Descanso_fin, 
    asistencia.Almuerzo_inicio, 
    asistencia.Almuerzo_fin, 
    asistencia.bano_inicio, 
    asistencia.bano, 
    asistencia.salida
FROM
    asistencia
INNER JOIN
    empleado
ON 
    asistencia.id_empleado = empleado.id_empleado
INNER JOIN
    cargo
ON 
    empleado.cargo = cargo.id_cargo
WHERE
    DATE(asistencia.entrada) = '$fechaHoy'
ORDER BY
    cargo.nombre ASC, asistencia.entrada ASC");

// Aplicar estilo para las celdas de datos (usar el mismo estilo que en export_excel.php)
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
    ],
];

// Agregar los datos a la hoja de cálculo
$row = 2; // Empezar en la segunda fila
while ($datos = $sql->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $datos['id_asistencia']);
    $sheet->setCellValue('B' . $row, $datos['asesor']);
    $sheet->setCellValue('C' . $row, $datos['cargo']);
    $sheet->setCellValue('D' . $row, $datos['entrada']);
    $sheet->setCellValue('E' . $row, $datos['1Descanso_inicio']);
    $sheet->setCellValue('F' . $row, $datos['1Descanso_fin']);
    $sheet->setCellValue('G' . $row, $datos['2Descanso_inicio']);
    $sheet->setCellValue('H' . $row, $datos['2Descanso_fin']);
    $sheet->setCellValue('I' . $row, $datos['Almuerzo_inicio']);
    $sheet->setCellValue('J' . $row, $datos['Almuerzo_fin']);
    $sheet->setCellValue('K' . $row, $datos['bano_inicio']);
    $sheet->setCellValue('L' . $row, $datos['bano']);
    $sheet->setCellValue('M' . $row, $datos['salida']);
    $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($dataStyle);
    $row++;
}

// Autoajustar ancho de columnas
foreach (range('A', 'M') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Crear un archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'Reporte_Asistencia_Hoy.xlsx';

// Enviar el archivo Excel como respuesta
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>