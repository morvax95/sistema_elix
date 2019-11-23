<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_actividad');
    }

    /** FUNCIONES DE CARGADO DE VISTAS **/
    public function index()
    {
        plantilla('actividad/index',null);
    }

    public function nuevo(){
        $this->load->model('model_login');
        $res['sucursal'] = $this->model_login->obtenerSucursales();
        plantilla('actividad/nueva_actividad',$res);
    }

    /*-----------------------------------        FUNCION REGISTRAR ACTIVIDAD      ------------------------------------*/
    public function registrarActividad(){

        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            $this->form_validation->set_rules('actividad_nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('actividad_direccion', 'Direccion', 'trim|required');
            $this->form_validation->set_rules('actividad_telefono', 'Telefono', 'trim');
            $this->form_validation->set_rules('actividad_email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('actividad_celular', 'Celular', 'trim|required');
            $this->form_validation->set_rules('actividad_ciudad', 'Ciudad', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                /** OBTENERMOS VALORES DE LOS INPUT **/
                $sesion = $this->session->userdata('usuario_sesion');
                $data = array(
                    'nombre_actividad' => $this->input->post('actividad_nombre'),
                    'telefono'          => $this->input->post('actividad_telefono'),
                    'celular'           => $this->input->post('actividad_celular'),
                    'direccion'         => $this->input->post('actividad_direccion'),
                    'email'             => $this->input->post('actividad_email'),
                    'tipo_impresion'    => $this->input->post('tipo_impresion'),
                    'ciudad'            => $this->input->post('actividad_ciudad'),
                    'sucursal_id'       => $this->input->post('actividad_sucursal'),
                );

                $res = $this->model_actividad->registrarActividad($data);

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

    /*---------------------------------------      FUNCION LISTAR ACTIVIDADES     ------------------------------------*/
    public function listarActividad(){
        $res = $this->model_actividad->listarActividad();
        echo json_encode($res);
    }

    /*-----------------------------------      FUNCION PARA MODIFICAR LAS ACTIVIDADES     ----------------------------*/
    public function modificarActividad()
    {

        if ($this->input->is_ajax_request()) {
            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            $id = $this->input->post('id-actividad');

            $datos = array(
                "nombre_actividad" => $this->input->post("nombre-actividad"),
                "direccion" => $this->input->post("direccion-actividad"),
                "telefono" => $this->input->post("telefono-actividad"),
                "email" => $this->input->post("email-actividad"),
                "celular" => $this->input->post("celular-actividad"),
                "ciudad" => $this->input->post("ciudad-actividad")
            );

            $res = $this->model_actividad->modificarActividad($id, $datos);

            if ($res) {
                $response['success'] = TRUE;
            } else {
                $response['success'] = FALSE;
            }
            echo json_encode($response);
        } else {
            show_404();
        }
    }

    /*----------- Funcion para deshabilitar actividad seleccionada ------------*/
    public function eliminar(){
        if($this->input->is_ajax_request()){
            $id_actividad = $this->input->post('id_actividad');
            $res = $this->model_actividad->eliminar($id_actividad);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        }else{
            show_404();
        }
    }

    /*----------- Funcion para habilitar actividad seleccionada ------------*/
    public function habilitar(){
        if($this->input->is_ajax_request()){
            $id_actividad = $this->input->post('id_actividad');
            $res = $this->model_actividad->habilitar($id_actividad);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        }else{
            show_404();
        }
    }

    public function existenDatos(){
        $cantidad = $this->model_actividad->existenDatos();
        echo $cantidad->cant;

    }
}
?>