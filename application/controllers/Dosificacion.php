<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosificacion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_dosificacion');
    }

    /** FUNCIONES DE CARGADO DE VISTAS **/
    public function index()
    {
        plantilla('dosificacion/index',null);
    }

    /*------------------------------      FUNCION PARA REGISTRAR UNA NUEVA DOSIFICACION    ---------------------------*/
    function nuevo(){
        plantilla('dosificacion/nueva_dosificacion',null);
    }

    function registrarDosificacion(){
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            $fecha_registro = date('Y-m-d');

            $this->form_validation->set_rules('autorizacion', 'Autorizacion', 'trim|required');
            $this->form_validation->set_rules('fecha_limite', 'Fecha limite', 'trim|required');
            $this->form_validation->set_rules('llave', 'Llave', 'trim|required');
            $this->form_validation->set_rules('leyenda', 'Leyenda', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                $data = array(
                    'autorizacion'      => $this->input->post('autorizacion'),
                    'nro_inicio'        => 1,
                    'llave'             => $this->input->post('llave'),
                    'fecha_limite'      => $this->input->post('fecha_limite'),
                    'leyenda'           => $this->input->post('leyenda'),
                    'fecha_registro'    => $fecha_registro,
                    'impresora'         => $this->input->post('impresora'),
                    'actividad'         => $this->input->post('actividad')
                );

                $res = $this->model_dosificacion->registrarDosificacion($data);

                if ($res) {
                    $response['success'] = TRUE;
                } else {
                    $response['success'] = FALSE;
                }

            } else {
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
        } else {
            show_404();
        }
    }

    /*-------------        FUNCION PARA VERIFICAR SI UNA IMPRESORA YA ESTA ASIGNADA A UNA ACTIVIDAD      -------------*/
    function verificarImpresora($impresora, $actividad){
        $res = $this->Model_asignacion->verificarImpresora($impresora, $actividad);
        foreach ($res as $total){
            return $total->total;
        }
    }

    /*---------------------------------      FUNCION PARA LISTAR LAS DOSIFICACION      -------------------------------*/
    function obtenerDosificaciones(){
        $res = $this->model_dosificacion->obtenerDosificaciones();
        echo json_encode($res);
    }

    /*---------------------------------      FUNCION PARA LISTAR LAS DOSIFICACION      -------------------------------*/
    function listarDosificacionInactiva(){
        $res = $this->model_dosificacion->listarDosificacionInactiva();
        echo json_encode($res);
    }

    /*-----------------------------      FUNCION PARA LISTAR DOSIFICACIONES CADUCADAS     ----------------------------*/
    function listarDosificacionCaducada(){
        $res = $this->model_dosificacion->listarDosificacionCaducada();
        echo json_encode($res);
    }

    /*---------------------------------      FUNCION PARA ELIMINAR UNA DOSIFICACION     ------------------------------*/
    function eliminarDosificacion(){
        $id = $this->input->post('id');
        $res = $this->Model_dosificacion->eliminarDosificacion($id);
        return $res;
    }

    /*--------------------------------       FUNCION PARA REACTIVAR UNA DOSIFICACION       ---------------------------*/
    function reactivarDosificacion(){
        $id = $this->input->post('id');
        $res = $this->model_dosificacion->reactivarDosificacion($id);
        return $res;
    }

    /*-------------------------    FUNCION PARA CALCULAR EL TIEMPOR RESTANTE DE UNA DOSIFICACION      ----------------*/
    function tiempoRestanteDosificacion(){
        $mensaje = $this->model_dosificacion->tiempoRestanteDosificacion();
        foreach ($mensaje as $restante){
            $restante = array(
                "nombre_actividad" => $restante->actividad,
                "restante" => $restante->restante
            );
        }
        return $restante;
    }

    /*-------------------------------      FUNCION ACTIVAR UNA DOSIFICACION         ----------------------------------*/
    function activar(){
        $id = $this->input->post("id_dosificacion");
        $res = $this->model_dosificacion->activar($id);
        return $res;
    }

    /*--------------------------------      FUNCION PARA CADUCAR UNA DOSIFICACION      -------------------------------*/
    function caducarDosificacion(){
        $dosificacion = $this->model_dosificacion->verificarDosificacionActiva();
        $filas = count($dosificacion);
        $resultado = array($filas);

        for($i = 0; $i < $filas; $i++){
            foreach ($dosificacion as $dos){
                $resultado[$i] = $dos;

                if ($resultado[$i]->restante < 0){
                    $this->Model_dosificacion->caducarDosificacion($resultado[$i]->id);
                }
                $i++;
            }
        }
        return;
    }
}