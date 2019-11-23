<?php

class Model_menu extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_categoria');
        $this->load->model('model_item');
    }

    public function get_menu(){
        // Obtenermos todas las categorias activas
        $categorias = $this->model_categoria->get_categorias();

        $menu['categorias'] = $categorias;

        foreach ($categorias as $row){
            $datos[$row->id] = $this->model_item->get_item($row->id);
            $menu['items'] = $datos;
        }

        return $menu;
    }
}