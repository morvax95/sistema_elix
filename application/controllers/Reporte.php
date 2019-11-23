<?php


class Reporte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_reporte');
    }

    public function index(){
        $this->load->model('model_login');
        $res['sucursal'] = $this->model_login->obtenerSucursales();
        plantilla('reporte/index',$res);
    }
    public function reporte_clientes()
    {
        $this->load->model('model_login');
        $res['sucursal'] = $this->model_login->obtenerSucursales();
        plantilla('reporte/reporte_clientes',$res);
    }
    public function reporte_productos()
    {
        $this->load->model('model_categoria');
        $res['sucursal'] = $this->model_categoria->obtenerCategoria();
        plantilla('reporte/reporte_productos',$res);
    }
    public function getFacturasLCV()
    {
        if ($this->input->is_ajax_request()){
            $mes = $this->input->post('mes');
            $anio = $this->input->post('anio');
            $sucursal = $this->input->post('sucursal');

            echo json_encode($this->model_reporte->getFacturasLCV($mes,$anio,$sucursal));
        }else{
            show_404();
        }
    }
    public function getClientes()
    {
        if ($this->input->is_ajax_request()){
            $mes = $this->input->post('mes');
            $anio = $this->input->post('anio');
            $sucursal = $this->input->post('sucursal');

            echo json_encode($this->model_reporte->getClientes());
        }else{
            show_404();
        }
    }
    public function getProductos()
    {
        if ($this->input->is_ajax_request()){
            $categoria = $this->input->post('categoria');
            echo json_encode($this->model_reporte->getProductos($categoria));
        }else{
            show_404();
        }
    }
    public function getTxt(){
        $mes = $this->uri->segment(3);
        $anio = $this->uri->segment(4);
        $sucursal = $this->uri->segment(5);

        $respuesta = $this->model_reporte->getFacturasLCV($mes,$anio,$sucursal);
        $empresa = $this->model_reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $archivo = "ventas_" . $mes.$anio."_". $nit_empresa . ".txt";
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        ob_start();

        $linea = "";
        $i = 1;
        foreach ($respuesta as $row){
            $nit_cliente = $row->ci_nit;
            $nombre = $row->nombre_cliente;
            $nro_factura = $row->nro_factura;
            $autorizacion = $row->autorizacion;
            $fecha = $row->fecha;
            $monto_total = $row->monto_total;
            $ice = $row->importe_ice;
            $excento = $row->importe_excento;
            $codigo_control = $row->codigo_control;
            $ventasGrabadas = $row->ventas_grabadas_taza_cero;
            $descuento = $row->descuento;
            $subtotal = $row->subtotal;
            $base_iva = $row->importe_base;
            $iva = $row->debito_fiscal;
            $estado = $row->estado;

            $linea .= $i . "|" . $fecha . "|" . $nro_factura . "|" . $autorizacion . "|" . $estado . "|" . $nit_cliente . "|" . $nombre . "|" . $monto_total . "|" . $ice . "|" . $excento . "|" . $ventasGrabadas . "|" . $subtotal . "|" . $descuento . "|" . $base_iva . "|" . $iva . "|" . $codigo_control. "\r\n";
            $i++;
        }
        ob_end_clean();
        header('Content-Type: application/txt');
        header('Content-Disposition: attachment;filename='.$archivo.'');
        header('Pragma:no-cache');
        echo $linea;
    }

    function obtener_mes($valor)
    {
        $result = '';
        switch ($valor) {
            case '01':
                $result = 'Enero';
                break;
            case '02':
                $result = 'Febrero';
                break;
            case '03':
                $result = 'Marzo';
                break;
            case '04':
                $result = 'Abril';
                break;
            case '05':
                $result = 'Mayo';
                break;
            case '06':
                $result = 'Junio';
                break;
            case '07':
                $result = 'Julio';
                break;
            case '08':
                $result = 'Agosto';
                break;
            case '09':
                $result = 'Septiembre';
                break;
            case '10':
                $result = 'Octubre';
                break;
            case '11':
                $result = 'Noviembre';
                break;
            case '12':
                $result = 'Diciembre';
                break;
        }
        return $result;
    }
   

    public function getExcel(){
        $mes = $this->uri->segment(3);
        $anio = $this->uri->segment(4);
        $sucursal = $this->uri->segment(5);

        $respuesta = $this->model_reporte->getFacturasLCV($mes,$anio,$sucursal);
        $empresa = $this->model_reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;


        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Libro de Ventas I.V.A.')
//            //CABEZERA DE LA TABLA
//            ->setCellValue('A2', 'ID Transaccion: '.$_REQUEST['idTransaccion'])
//            ->setCellValue('C2', 'Paciente: '.$_REQUEST['paciente'])
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Periodo Fiscal: ' . $this->obtener_mes($mes))
            ->setCellValue('H3', 'Año Fiscal: ' . $anio)
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'FECHA')
            ->setCellValue('C5', 'NRO. FACTURA')
            ->setCellValue('D5', 'NRO. AUTORIZACION')
            ->setCellValue('E5', 'ESTADO')
            ->setCellValue('F5', 'NIT')
            ->setCellValue('G5', 'NOMBRE CLIENTE')
            ->setCellValue('H5', 'MONTO TOTAL')
            ->setCellValue('I5', 'IMPORTE ICE')
            ->setCellValue('J5', 'IMPORTE EXENCTO')
            ->setCellValue('K5', 'VENTAS GRABADAS A TASA CERO')
            ->setCellValue('L5', 'SUBTOTAL')
            ->setCellValue('M5', 'DESCUENTOS Y BONIDICACIONES')
            ->setCellValue('N5', 'IMPORTE BASE PARA DEBITO FISCAL')
            ->setCellValue('O5', 'DEBITO FISCAL')
            ->setCellValue('P5', 'CODIGO DE CONTROL');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('J5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('K5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('L5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('M5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('N5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('O5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('P5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($respuesta as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->fecha)
                ->setCellValue('C' . $fila, $row->nro_factura)
                ->setCellValue('D' . $fila, $row->autorizacion.' ')
                ->setCellValue('E' . $fila, $row->estado)
                ->setCellValue('F' . $fila, $row->ci_nit)
                ->setCellValue('G' . $fila, $row->nombre_cliente)
                ->setCellValue('H' . $fila, number_format($row->monto_total, 2).' ')
                ->setCellValue('I' . $fila, number_format($row->importe_ice, 2).' ')
                ->setCellValue('J' . $fila, number_format($row->importe_excento, 2).' ')
                ->setCellValue('K' . $fila, number_format($row->ventas_grabadas_taza_cero, 2).' ')
                ->setCellValue('L' . $fila, number_format($row->subtotal, 2).' ')
                ->setCellValue('M' . $fila, number_format($row->descuento, 2).' ')
                ->setCellValue('N' . $fila, number_format($row->importe_base, 2).' ')
                ->setCellValue('O' . $fila, number_format($row->debito_fiscal, 2).' ')
                ->setCellValue('P' . $fila, $row->codigo_control);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('M' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('N' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('O' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('P' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(TRUE);

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ventas' . $mes . $anio . "_" . $nit_empresa . '.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }
  
    public function getExcelClientes(){
        $mes = $this->uri->segment(3);
        $anio = $this->uri->segment(4);
        $sucursal = $this->uri->segment(5);

        $respuesta = $this->model_reporte->getClientes();
        $empresa = $this->model_reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");
        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'LISTA DE CLIENTES')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'CI')
            ->setCellValue('C5', 'CLIENTE')
            ->setCellValue('D5', 'TELEFONO')
            ->setCellValue('E5', 'DIRECCION')
            ->setCellValue('F5', 'EMAIL');
      
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE);
        
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($respuesta as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->ci_nit)
                ->setCellValue('C' . $fila, $row->nombre_cliente)
                ->setCellValue('D' . $fila, $row->telefono.' ')
                ->setCellValue('E' . $fila, $row->direccion)
                ->setCellValue('F' . $fila, $row->email);
             
                
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);


//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Clientes' . $mes . $anio . "_" . $nit_empresa . '.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }
  

public function getExcelProducto(){
    $mes = $this->uri->segment(3);
    $anio = $this->uri->segment(4);
    $sucursal = $this->uri->segment(5);
    $categoria = $this->uri->segment(6);

    $respuesta = $this->model_reporte->getListaProductos();
    $empresa = $this->model_reporte->getNitEmpresa();
    $nit_empresa = $empresa->nit;
    $nombre_empresa = $empresa->nombre_empresa;

    $this->load->library("excel/PHPExcel");
    //membuat objek PHPExcel
    $objPHPExcel = new PHPExcel();

    //Unir celdas
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
    $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
    $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
    $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

    ->setCellValue('A1', 'LISTA DE PRODUCTOS')
//            //CABEZERA DE LA TABLA
        ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
        ////Encabezado de la tabla
        ->setCellValue('A5', 'NRO.')
        ->setCellValue('B5', 'PRODUCTO')
        ->setCellValue('C5', 'PRECIO VENTA')
        ->setCellValue('D5', 'ESTADO')
        ->setCellValue('E5', 'CATEGORIA');
     
  
    //poner en negritas
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
        ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE);
        
    
//centrar los titulos
    $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
       
// //Pintamos los bordes
    $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
        ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
        ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
        ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
        ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        
    $fila = 6; //enpieza a escribir desde la linea 6\
    $i = 1;
    foreach ($respuesta as $row) {

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $fila, $i)
            ->setCellValue('B' . $fila, $row->producto)
            ->setCellValue('C' . $fila, $row->precio)
            ->setCellValue('D' . $fila, $row->estado.' ')
            ->setCellValue('E' . $fila, $row->categoria);
            
         
            
//     //Pintar los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            
           
        $fila = $fila + 1;
        $i++;
    }
//ESTABLECE LA ANCHURA DE LAS CELDA
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
    


//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
    header('Content-Disposition: attachment;filename="Productos' . $mes . $anio . "_" . $nit_empresa . '.xlsx"');
//unduh file
    $objWriter->save("php://output");
}


}





