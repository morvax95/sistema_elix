<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultar_venta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_consultar_venta');
        $this->load->model('model_venta');
    }

    public function index()
    {
        plantilla('consultar_venta/index', null);
    }

    public function reimpresiones(){
        plantilla('consultar_venta/reimpresion');
    }
    public function obtener_lista_factura()
    {
        echo json_encode($this->model_consultar_venta->obtener_lista_factura());
    }

    public function obtener_lista_factura_server_side()
    {
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search')['value'];

            $datos_facturas = $this->model_consultar_venta->obtener_lista_factura_server_side($start,$length,$search);

            $datos = $datos_facturas['datos'];
            $totalDatos = $datos_facturas['total'];
            $datos_array = array();
            foreach ($datos->result_array() as $row){
                $array = array();
                $array['id'] = $row['id'];
                $array['nro_factura'] = $row['nro_factura'];
                $array['autorizacion'] = $row['autorizacion'];
                $array['fecha_transaccion'] = $row['fecha_transaccion'];
                $array['nombre_cliente'] = $row['nombre_cliente'];
                $array['monto_total'] = $row['monto_total'];
                $datos_array[]= $array;
            }

            $cantidad_facturas = $datos->num_rows();

            $json_data = array(
                'draw'              =>  intval($this->input->post('draw')),
                'recordsTotal'      =>  intval($cantidad_facturas),
                'recordsFiltered'   =>  intval($totalDatos),
                'data'              =>  $datos_array,
            );

            echo json_encode($datos->result());
        }else{
            show_404();
        }
    }

    public function anularFactura()
    {
            $id = $this->input->post('id_venta');
            $res = $this->model_consultar_venta->anularFactura($id);
            if($res){
                echo true;
            }else{
                echo 'error';
            }
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

    /*********** Reimpresion de la factura **************/
    public function imprimirCopiaFactura()
    {
        $id = $this->uri->segment(3);
        $respuesta = $this->model_venta->imprimirFactura($id);
        $datosImpresion['datos_factura'] = $respuesta['datos_factura'];
        $datosImpresion['datos_venta_detalle'] = $respuesta['datos_venta_detalle'];
        $datosImpresion['qr_image'] = $respuesta['qr_image'];

        $this->load->view('consultar_venta/copia_factura',$datosImpresion);
    }

}