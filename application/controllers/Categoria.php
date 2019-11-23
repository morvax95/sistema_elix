<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_categoria');
    }

    public function index(){
        plantilla('categoria/index');
    }

    public function registrar_categoria(){
        if ($this->input->is_ajax_request()){
            echo $this->model_categoria->registrar_categoria();
        }else{
            show_404();
        }
    }

    public function editar_categoria(){
        if ($this->input->is_ajax_request()){
            echo $this->model_categoria->editar_categoria();
        }else{
            show_404();
        }
    }

    public function eliminar_categoria(){
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_categoria');

            $res = $this->model_categoria->eliminar_categoria($id);
            if ($res) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    public function get_categorias(){
        echo json_encode($this->model_categoria->get_categorias());
    }

    public function get_categoria(){

    }

    public function existe_categoria(){
        $cantidad = $this->model_categoria->existe_categoria();
        echo $cantidad->cantidad;
    }
}