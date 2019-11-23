<?php


class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_login');

    }

    function index(){
//        $this->load->view('login/creacion');
        $res['sucursal'] = $this->model_login->obtenerSucursales();
        $this->load->view('login/index',$res);
    }

    function acceso(){
        if($this->model_login->existe_sucursal() > 0){
        $res['sucursal'] = $this->model_login->obtenerSucursales();

            $this->load->view('login/index',$res);
        }else{
            $this->registro_sucursal();
        }
    }

    public function  registro_sucursal(){
        if ($this->model_login->existe_sucursal()>1){
            redirect(site_url('login'));
        }else{
            $this->load->view('login/registro',null);
        }
    }

    function verificar(){
//        if ($this->input->is_ajax_request())
//        {
            $username = $this->input->post('usuario');
            $clave = $this->input->post('clave');
            $sucursal = $this->input->post('sucursal');

            /*  Mensajes de respuesta
             *  error1 = datos incorrectos
             *  error2 = usuario de baja.
             * */
            echo json_encode($this->model_login->login($username, $clave,$sucursal));
//        } else {
//            show_404();
//        }
    }

    function set_impresora(){
        $sesion = $this->session->userdata('usuario_sesion');
        $data['imp'] = $sesion['sucursal'];
        $this->load->view('login/set_impresora',$data);
    }

    function guardarSesion(){
//        if ($this->input->is_ajax_request())
//        {
            $user_id = $this->input->post('user_id');
            $impre_id = $this->input->post('impresora_sel');
            $marca = $this->input->post('marca');

            echo $this->model_login->inicio_sesion($user_id, $impre_id,$marca);
//        } else {
//            show_404();
//        }
    }

    public function cerrar_sesion()
    {
        $this->model_login->cerrar_sesion();
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }

    public function registrar_sucursal(){
        $registro['nit'] = trim($this->input->post('nit_empresa'));
        $registro['nombre_empresa'] = trim(mb_strtoupper($this->input->post('nombre_empresa'),'UTF-8'));
        $registro['sucursal'] = trim($this->input->post('nombre_sucursal'));
        $registro['estado'] = 1;

        $this->db->insert('sucursal',$registro);

        // Registramos la impresora
        $impresora['marca'] = trim($this->input->post('marca_impresora'));
        $impresora['serial'] = trim($this->input->post('serial_impresora'));
        $impresora['sucursal_id'] = 1;
        $impresora['activo'] = 0;
        $this->db->insert('impresora',$impresora);

        redirect(site_url('login'));
    }
}