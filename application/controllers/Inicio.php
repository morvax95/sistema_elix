<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_inicio');
    }

    public function index()
    {
        $res = $this->model_inicio->obtenerAvisos();

        plantilla('inicio/index', $res);
    }

    /** vista para el cambio de contraseña, funcion no explicita por cuestion de seguridad */
    public function cambio()
    {
        plantilla('inicio/cambiar', null);
    }

    public function cerrar(){
        $this->model_login->cerrar_sesion();
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }

    public function avisos(){
        $res = $this->model_inicio->obtenerAvisos();
        echo var_dump($res);
    }

    public function verificar(){
        if($this->input->is_ajax_request()){
            $sesion = $this->session->userdata('usuario_sesion');
            $usuario = $sesion['idUsuario'];
            $clave = trim($this->input->post('clave'));

            $respuesta = $this->model_inicio->verificar($usuario);
            if(password_verify($clave, $respuesta->clave)){
                echo true;
            }else{
                echo 'error';
            }
        }else{
            show_404();
        }
    }

    public function confirmar_cambio(){
        if($this->input->is_ajax_request()){
            $sesion = $this->session->userdata('usuario_sesion');
            $usuario = $sesion['idUsuario'];
            $clave_nueva = trim($this->input->post('clave-nueva'));
            $clave_confirmar = trim($this->input->post('clave-nueva-r'));

            if($clave_nueva === $clave_confirmar){
                echo ($this->model_inicio->confirma_cambio($usuario,$clave_confirmar));
            }else{
                echo 'error';
            }
        }else{
            show_404();
        }
    }
}