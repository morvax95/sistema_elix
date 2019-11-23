<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_cliente');
    }

    public function index(){
        plantilla('cliente/index',null);
    }

    public function nuevo(){
        plantilla('cliente/nuevo_cliente',null);
    }



    /*---------------- METODOS --------------------------*/
    public function listar_clientes(){
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->model_cliente->listar_clientes());
        }else{
            show_404();
        }
    }
    /* Obtenermos a todos los clientes ***/
    public function listar_clientes_server_side(){
        if ($this->input->is_ajax_request()) {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search')['value'];

            $datos_clientes = $this->model_cliente->listar_clientes_server_side($start,$length,$search);

            $resultado = $datos_clientes['datos'];
            $totalDatos = $datos_clientes['total'];

            $datos = array();
            foreach ($resultado->result_array() as $row){
                $array = array();
                $array['id'] = $row['id'];
                $array['ci_nit'] = $row['ci_nit'];
                $array['nombre_cliente'] = $row['nombre_cliente'];
                $array['telefono'] = $row['telefono'];
                $array['direccion'] = $row['direccion'];
                $array['email'] = $row['email'];
                $array['estado'] = $row['estado'];
                $datos[]= $array;
            }

            $cantidad_cliente = $resultado->num_rows();

            $json_data = array(
                'draw'              =>  intval($this->input->post('draw')),
                'recordsTotal'      =>  intval($cantidad_cliente),
                'recordsFiltered'   =>  intval($totalDatos),
                'data'              =>  $datos,
            );

            echo json_encode($resultado->result());
        }else{
            show_404();
        }
    }

    /* Registramos a un nuevo cliente*/
    public function registrar_cliente(){
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
            $this->form_validation->set_rules('ci_nit', 'CI o NIT', 'trim|required');
            $this->form_validation->set_rules('nombre_cliente', 'nombre', 'trim|required');
            $this->form_validation->set_rules('telefono_cliente', 'telefono', 'trim|required');
            $this->form_validation->set_rules('email_cliente', 'email', 'trim|valid_email');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                /** OBTENERMOS VALORES DE LOS INPUT **/
                $obj_cliente['ci_nit'] = $this->input->post('ci_nit');
                $obj_cliente['nombre_cliente'] = mb_strtoupper($this->input->post('nombre_cliente'), "UTF-8");
                $obj_cliente['telefono'] = $this->input->post('telefono_cliente');
                $obj_cliente['direccion'] = mb_strtoupper($this->input->post('direc_cliente'), "UTF-8");
                $obj_cliente['email'] = $this->input->post('email_cliente');

                $res = $this->model_cliente->registrar_cliente($obj_cliente);
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

    public function editarCliente(){
        if ($this->input->is_ajax_request()) {

            $response = array(
                'success' => FALSE,
                'messages' => array()
            );

            /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
            $this->form_validation->set_rules('editar_ci', 'CI o NIT', 'trim|required');
            $this->form_validation->set_rules('editar_nombre', 'nombre', 'trim|required');
            $this->form_validation->set_rules('editar_telefono', 'telefono', 'trim|required');
            $this->form_validation->set_rules('editar_email', 'email', 'trim|valid_email');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            if ($this->form_validation->run() === true) {
                /** OBTENERMOS VALORES DE LOS INPUT **/
                $id = $this->input->post('cliente_id');
                $obj_cliente['ci_nit'] = $this->input->post('editar_ci');
                $obj_cliente['nombre_cliente'] = mb_strtoupper($this->input->post('editar_nombre'), "UTF-8");
                $obj_cliente['telefono'] = $this->input->post('editar_telefono');
                $obj_cliente['direccion'] = mb_strtoupper($this->input->post('editar_direccion'), "UTF-8");
                $obj_cliente['email'] = $this->input->post('editar_email');

                $res = $this->model_cliente->editarCliente($obj_cliente,$id);
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

    /* Eliminamos al cliente seleccionado */
    public function eliminar(){
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_cliente');

            $res = $this->model_cliente->eliminar($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    public function habilitar(){
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_cliente');

            $res = $this->model_cliente->habilitar($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }


    public function getCliente()
    {
        $dato = $this->input->post_get('name_startsWith');
        $tipo = $this->input->post_get('type');
        if($tipo === 'ci_nit'){
            $this->db->like('ci_nit',$dato);
            $this->db->where('id !=',1);
            $this->db->where('id !=',2);
            $res = $this->db->get('cliente');
            if($res->num_rows() > 0){
                foreach ($res->result_array() as $row){
                    $data[$row['ci_nit']] = $row['nombre_cliente'].'/'.$row['id'];
                }
                echo json_encode($data); //format the array into json data
            }
        }else{
            $this->db->like('nombre_cliente',$dato);
            $this->db->where('id !=',1);
            $this->db->where('id !=',2);
            $res = $this->db->get('cliente');
            if($res->num_rows() > 0){
                foreach ($res->result_array() as $row){
                    $data[$row['nombre_cliente']] = $row['ci_nit'].'/'.$row['id'];
                }
                echo json_encode($data); //format the array into json data
            }
        }
    }

    public function exite_cliente(){
        $nitCliente = $this->uri->segment(3);
        echo $this->model_cliente->exite_cliente($nitCliente);
    }

}