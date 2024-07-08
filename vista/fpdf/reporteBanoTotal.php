<?php

if (!empty($_GET["txtFechainicio"])  and !empty($_GET["txtFechafinal"]) and !empty($_GET["txtAsesor"])) {
    require('./fpdf.php');
    $fechaInicio = $_GET["txtFechainicio"];
    $fechaFinal = $_GET["txtFechafinal"];
    $empleado = $_GET["txtAsesor"];

    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            include '../../modelo/conexion.php'; //llamamos a la conexion BD

            $consulta_info = $conexion->query(" select * from empresa "); //traemos datos de la empresa desde BD
            $dato_info = $consulta_info->fetch_object();
            $this->Image('logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
            $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
            $this->Cell(90); // Movernos a la derecha
            $this->SetTextColor(0, 0, 0); //color
            //creamos una celda o fila
            $this->Cell(110, 15, utf8_decode($dato_info->nombre), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
            $this->Ln(3); // Salto de línea
            $this->SetTextColor(103); //color

            /* UBICACION */
            $this->Cell(180);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode("Ubicación : " . $dato_info->ubicacion), 0, 0, '', 0);
            $this->Ln(5);

            /* TELEFONO */
            $this->Cell(180);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(59, 10, utf8_decode("Teléfono : " . $dato_info->telefono), 0, 0, '', 0);
            $this->Ln(5);

            /* RUC */
            $this->Cell(180);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(85, 10, utf8_decode("RUC : " . $dato_info->ruc), 0, 0, '', 0);
            $this->Ln(10);

            /* TITULO DE LA TABLA */
            //color
            $this->SetTextColor(0, 95, 189);
            $this->Cell(100); // mover a la derecha
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(100, 10, utf8_decode("REPORTE DE TIEMPO DE BAÑO "), 0, 1, 'C', 0);
            $this->Ln(7);

            /* CAMPOS DE LA TABLA */
            //color
            $this->SetFillColor(125, 173, 221); //colorFondo
            $this->SetTextColor(0, 0, 0); //colorTexto
            $this->SetDrawColor(163, 163, 163); //colorBorde
            $this->SetFont('Arial', 'B', 11);
            // Centrar la tabla en la página
            $this->SetX(($this->GetPageWidth() - 195) / 2);
            
            $this->Cell(15, 10, utf8_decode('N°'), 1, 0, 'C', 1);
            $this->Cell(80, 10, utf8_decode('EMPLEADO'), 1, 0, 'C', 1);
            $this->Cell(50, 10, utf8_decode('CARGO'), 1, 0, 'C', 1);
            $this->Cell(50, 10, utf8_decode('TIEMPO BAÑO'), 1, 1, 'C', 1);
        }

        // Pie de página
        function Footer()
        {
            $this->SetY(-15); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

            $this->SetY(-15); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
            $hoy = date('d/m/Y');
            $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
        }
    }

    include '../../modelo/conexion.php';
    /* CONSULTA INFORMACION DEL HOSPEDAJE */

    $pdf = new PDF();
    $pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
    $pdf->AliasNbPages(); //muestra la pagina / y total de paginas

    $i = 0;
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetDrawColor(163, 163, 163); //colorBorde

    if ($empleado == "todos") {
        $sql = $conexion->query(" SELECT
            asistencia.id_asistencia,
            asistencia.id_empleado,
            empleado.nombre,
            empleado.apellido,
            cargo.nombre AS 'cargo',
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(asistencia.bano))), '%H:%i:%s') as 'totalBano'
            FROM
            asistencia
            INNER JOIN empleado ON asistencia.id_empleado = empleado.id_empleado
            INNER JOIN cargo ON empleado.cargo = cargo.id_cargo
            where entrada BETWEEN '$fechaInicio' and '$fechaFinal'
            GROUP BY asistencia.id_empleado
            ORDER BY id_empleado ASC ");
    } else {
        $sql = $conexion->query(" SELECT
            asistencia.id_asistencia,
            asistencia.id_empleado,
            empleado.nombre,
            empleado.apellido,
            cargo.nombre AS 'cargo',
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(asistencia.bano))), '%H:%i:%s') as 'totalBano'
            FROM
            asistencia
            INNER JOIN empleado ON asistencia.id_empleado = empleado.id_empleado
            INNER JOIN cargo ON empleado.cargo = cargo.id_cargo
            where asistencia.id_empleado = $empleado AND entrada BETWEEN '$fechaInicio' and '$fechaFinal'
            GROUP BY asistencia.id_empleado
            ORDER BY id_empleado ASC");
    }

    while ($datos_reporte = $sql->fetch_object()) {
        $i = $i + 1;
        /* TABLA */
        $pdf->SetX(($pdf->GetPageWidth() - 195) / 2); // Centrar la tabla en la página
        $pdf->Cell(15, 10, utf8_decode($i), 1, 0, 'C', 0);
        $pdf->Cell(80, 10, utf8_decode($datos_reporte->nombre . " " . $datos_reporte->apellido), 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode($datos_reporte->cargo), 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode($datos_reporte->totalBano), 1, 1, 'C', 0);
    }

    $pdf->Output('Reporte Tiempo Baño.pdf', 'I'); //nombreDescarga, Visor(I->visualizar - D->descargar)
}
?>