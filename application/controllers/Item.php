<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_item');
    }

    public function index()
    {
        plantilla('item/index', null);
    }

    public function nuevo(){
        plantilla('item/nuevo_item');
    }

    public function editar(){
        plantilla('item/editar_item');
    }

    public function registrar_item()
    {
        if ($this->input->is_ajax_request()) {
            echo $this->model_item->registrar_item();
        } else {
            show_404();
        }
    }

    public function editar_item()
    {
        if ($this->input->is_ajax_request()) {
            echo $this->model_item->editar_item();
        } else {
            show_404();
        }
    }

    public function get_lista_item()
    {
        echo json_encode($this->model_item->get_lista_item());
    }

    public function eliminar()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_item');

            $res = $this->model_item->eliminar($id);
            if ($res) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    public function buscar_item()
    {
        $dato = $this->input->post_get('name_startsWith');
        $this->db->like('nombre_item', $dato);
        $res = $this->db->get('item');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {
                $data[$row['nombre_item']] = $row['precio_venta'].'/';
            }
            echo json_encode($data); //format the array into json data
        }
    }
}