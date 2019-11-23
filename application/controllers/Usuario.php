<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* verificamos si el usuario esta logueado */
//        if(verificar_logueado()!=1){redirect('login');};
//        /*** Cargamos el menu ****/
//        cargar_menu();

        $this->load->model('model_usuario');
    }

    /****************** FUNCIONES DE CARGADO DE VISTAS ******************/
    public function index()
    {
//        $datosesion = $this->session->userdata('usuario_sesion');
//        $data['dato_sesion'] = $datosesion;

        plantilla('usuario/index',null);
    }

    /****************** FUNCIONES DE CARGADO DE VISTAS ******************/
    public function nuevo()
    {
        $this->load->model('model_login');
        $res['sucursal'] = $this->model_login->obtenerSucursales();
        plantilla('usuario/nuevo_usuario',$res);
    }

    public function editar()
    {
        if($this->uri->segment(2)=='editar') {
            $usuario_id = $_POST['idusuario'];
            $res = $this->model_usuario->obtener_privilegios();
            $res1 = $this->model_usuario->obtener_privilegios_users($usuario_id);
            $this->load->model('model_login');
            $privilegios['sucursales'] = $this->model_login->obtenerSucursales();
            $privilegios['sucursales_seleccionadas'] = $this->model_usuario->obtener_sucursales_seleccionadas($usuario_id);
            $privilegios['funciones'] = $res;
            $privilegios['asignados'] = $res1;

        }

        plantilla('usuario/editar_usuario',$privilegios);
    }
    /****************** FUNCIONES DE REGISTRO, MODIFICACIONES, LISTAR Y BAJAS *****************/

    /******** FUNCION PARA REGISTRAR A UN NUEVO usuario  ********/
    public function registrar_usuario()
    {
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
            $this->form_validation->set_rules('ci', 'CI', 'trim|required');
            $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
            $this->form_validation->set_rules('telefono', 'telefono', 'trim');
            $this->form_validation->set_rules('usuario', 'usuario', 'trim|required|min_length[3]|max_length[15]|is_unique[usuario.usuario]');
            $this->form_validation->set_rules('clave', 'contraseña', 'trim|required|min_length[3]|max_length[15]');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                /** OBTENERMOS VALORES DE LOS INPUT **/
                $obj_usuario['ci'] = $this->input->post('ci');
                $obj_usuario['nombre_usuario'] = mb_strtoupper($this->input->post('nombre'), "UTF-8");
                $obj_usuario['telefono'] = $this->input->post('telefono');
                $obj_usuario['cargo'] = $this->input->post('cargo');
                $obj_usuario['usuario'] = $this->input->post('usuario');
                $obj_usuario['clave'] = password_hash($this->input->post('clave'), PASSWORD_BCRYPT);
                $obj_usuario['estado'] = 1;
                $menu = $this->input->post('menu');

                $lista_sucursales = $this->input->post('seleccion_sucursal');

                $res = $this->model_usuario->registrar_usuario($obj_usuario,$menu,$lista_sucursales);
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

    /***************** FUNCION PARA EDITAR LOS DATOS DE UN usuario ******************/
    public function editar_usuario()
    {
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
            $this->form_validation->set_rules('ci-editar', 'CI', 'trim|required');
            $this->form_validation->set_rules('nombre-editar', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('telefono-editar', 'Telefono', 'trim');
            $this->form_validation->set_rules('usuario-editar', 'Usuario', 'trim|required|min_length[3]|max_length[15]');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                /** OBTENERMOS VALORES DE LOS INPUT **/
                $obj_usuario['ci'] = $this->input->post('ci-editar');
                $obj_usuario['nombre_usuario'] = mb_strtoupper($this->input->post('nombre-editar'), "UTF-8");
                $obj_usuario['telefono'] = $this->input->post('telefono-editar');
                $obj_usuario['usuario'] = $this->input->post('usuario-editar');
                $menu = $this->input->post('menu-editar');
                $id = $this->input->post('usuario-editar-id');
                $lista_sucursales = $this->input->post('editar_seleccion_sucursal');

                $res = $this->model_usuario->editar_usuario($obj_usuario, $id, $menu,$lista_sucursales);
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

    /******************* FUNCION QUE DA DE BAJA A UN usuario ESPECIFICO *************************/
    public function eliminar()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_usuario');

            $res = $this->model_usuario->eliminar($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    /******************* FUNCION PARA OBTENER LOS DATOS DE UN usuario *********************/
    public function obtener_usuario(){
        $id_usuario = $this->input->post('usuario');
        $datos = $this->model_usuario->obtener_usuario($id_usuario);
        echo json_encode($datos);
    }

    /********* Funcion para obtener los usuario con el nombre y apellido concatenado para autocompletar *******/
    public function getUsuarios(){
        $res = $this->model_usuario->getUsuarios();
        echo json_encode($res);
    }

    /******************* FUNCION PARA OBTENER A TODOS LOS usuario *********************/
    public function obtener_usuarios()
    {
        $datos = $this->model_usuario->obtener_usuarios();
        echo json_encode($datos);
    }

    /***************** FUNCION QUE ACTIVA LOS usuario DADOS DE BAJA ******************/
    public function reactivar()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_usuario');
            $res = $this->model_usuario->reactivar($id);
            if ($res){
                echo true;
            }else{
                echo false;
            }
        } else {
            show_404();
        }
    }

    public function obtener_privilegios(){
        $res = $this->model_usuario->obtener_privilegios();
        echo json_encode($res);
    }
}