<?php


class Despacho extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_despacho');
    }

    /** FUNCIONES DE CARGADO DE VISTAS **/
    public function index()
    {
        plantilla('despacho/index',null);
    }

}