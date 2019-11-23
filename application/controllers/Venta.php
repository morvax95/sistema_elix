<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_venta');
    }

    // Ingreso a la vista de venta rapida
    public function index()
    {
        $this->load->model('model_dosificacion');
        $sesion = $this->session->userdata('usuario_sesion');
        $dosificaciones_activas = $this->model_dosificacion->verificar_doficacion_activa($sesion['idSucursal'],$sesion['id_impresora']);
        if($dosificaciones_activas > 0){
            $this->load->model('model_menu');
            $datos = $this->model_menu->get_menu();
            $this->db->where(array('usuario_id'=>$sesion['idUsuario'],'sucursal_id'=>$sesion['idSucursal']));
            $this->db->delete('item_agregado');
            plantilla('venta/venta', $datos);
        }else{
            show_error('<p style="font-size:12pt">Esta sucursal no cuenta con una dosificacion activa o la impresora que 
                    selecciono no esta asignada a una dosificacion, por favor contactese con el admininstrador.
                    <br><br><a class="btn btn-danger" href="' . site_url() . 'inicio"> Volver</a> </p>','','ERROR DE DOSIFICACION');
        }
    }

    /*-------------------------------------------------
     * Funcion para el registro de venta de otros productos
     *------------------------------------------------- */
    public function registrar_venta()
    {
        if ($this->input->is_ajax_request()) {

            $res = $this->model_venta->registrar_venta();
            echo json_encode($res);
        } else {
            show_404();
        }
    }


    public function registroDetalleVenta()
    {
        if ($this->input->is_ajax_request()) {
            $detalle['venta_id'] = $this->input->post('venta_id');
            $detalle['detalle'] = $this->input->post('detalle');
            $detalle['cantidad'] = $this->input->post('cantidad');
            $detalle['precio_venta'] = $this->input->post('precio');

            $this->model_venta->registroDetalleVenta($detalle);
        } else {
            show_404();
        }
    }

    public function adicionar(){
        if($this->input->is_ajax_request()){
            echo $this->model_venta->adicionar();
        }else{
            show_404();
        }
    }

    public function disminuir(){
        if($this->input->is_ajax_request()){
            echo $this->model_venta->disminuir();
        }else{
            show_404();
        }
    }

    public function adicionar_cantidad(){
        if($this->input->is_ajax_request()){
            echo $this->model_venta->adicionar_cantidad();
        }else{
            show_404();
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

    /**** Imprime las facturas que son de materia de madera *******/
    public function imprimirFactura()
    {
        $venta_id = $this->uri->segment(3);
        $respuesta = $this->model_venta->imprimirFactura($venta_id);
        $datosImpresion['datos_factura'] = $respuesta['datos_factura'];
        $datosImpresion['datos_venta_detalle'] = $respuesta['datos_venta_detalle'];
        $datosImpresion['qr_image'] = $respuesta['qr_image'];

        $this->load->view('venta/impresion_factura',$datosImpresion);
    }

}