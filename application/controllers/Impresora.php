<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impresora extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_impresora');
    }

    public function index()
    {
        plantilla('impresora/index', null);
    }

    /*---------------------------------
     * Funcion para registrar impresora
     * -------------------------------*/
    public function registrarImpresora()
    {
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            $fecha_registro = date('Y-m-d');

            $this->form_validation->set_rules('marca', 'marca', 'trim|required');
            $this->form_validation->set_rules('serial', 'serial', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {

                $data = array(
                    'marca' => $this->input->post('marca'),
                    'serial' => $this->input->post('serial'),
//                    'sucursal_id' => $this->input->post('');
                );
                $res = $this->model_impresora->registrarImpresora($data);

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

    /*--------------------------------------------
     * Funcion para editar impresora seleccionada
     * -------------------------------------------*/
    public function editarImpresora()
    {
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            $fecha_registro = date('Y-m-d');

            $this->form_validation->set_rules('edita_marca', 'marca', 'trim|required');
            $this->form_validation->set_rules('edita_serial', 'serial', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {

                $data = array(
                    'marca' => $this->input->post('edita_marca'),
                    'serial' => $this->input->post('edita_serial')
                );
                $id = $this->input->post('id_impresora');
                $res = $this->model_impresora->editarImpresora($data,$id);

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

    /*------------------------------------------------
     * Funcion para dar baja a impresora seleccionada
     * -----------------------------------------------*/
    public function darBaja()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_impresora');

            $res = $this->model_impresora->eliminar($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    /*-----------------------------------------------
     * Funcion para habilitar impresora seleccionada
     * ----------------------------------------------*/
    public function habilitar()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_impresora');

            $res = $this->model_impresora->habilitar($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    /*-----------------------------------------------
     * Funcion para obtener la lista de impresora
     * ----------------------------------------------*/
    public function obtenerImpresoras(){
        echo json_encode($this->model_impresora->obtenerImpresoras());
    }

    public function existenDatos(){
        $cantidad = $this->model_impresora->existenDatos();
        echo $cantidad->cant;

    }

    public function getImpresorasLogin(){
        if($this->input->is_ajax_request()){
            $sesion = $this->session->userdata('usuario_sesion');
            echo json_encode($this->model_impresora->getImpresorasLogin($sesion['sucursal']));
        }else{
            show_404();
        }
    }

}