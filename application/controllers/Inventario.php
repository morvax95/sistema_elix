<?php

class Inventario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_inventario');
    }

    /** FUNCIONES DE CARGADO DE VISTAS **/
    public function index()
    {
        plantilla('inventario/index',null);
    }
    public function nuevo(){
        plantilla('inventario/nueva_compra');
    }

    /*FUNCION QUE REGISTRA PRODUCTO*/
    public function registrar_producto(){
        if ($this->input->is_ajax_request()){
           echo $this->model_inventario->registrar_producto();
        }else{
            show_404();
        }
    }

    /*FUNCION QUE DEVUELVE LOS PRODUCTOS*/
    public function get_productos(){
       echo $this->model_inventario->get_productos();
    }

    /*FUNCION QUE ELIMINA A X PRODUCTO*/
    public function eliminar_producto(){
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_producto');

            $res = $this->model_inventario->eliminar_producto($id);
            if ($res) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    public function editar_producto(){
        if ($this->input->is_ajax_request()){
            echo $this->model_inventario->editar_producto();
        }else{
            show_404();
        }
    }
}