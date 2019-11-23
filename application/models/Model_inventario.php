<?php

/**
 * Created by PhpStorm.
 * User: merce
 * Date: 8/9/2017
 * Time: 4:42 PM
 */
class Model_inventario extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function registrar_producto(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('nombre_producto', 'nombre', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $obj_producto['nombre_producto'] = strtoupper($this->input->post('nombre_producto'));
            $obj_producto['categoria_id'] = strtoupper($this->input->post('categorias'));
            $obj_producto['estado'] = 'ACTIVO';

            $response['success'] = $this->db->insert('producto',$obj_producto);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }
    /*OBTENCION DE PRODUCTOS*/
    public function get_productos(){
        return json_encode($this->db->get_where('producto',array('estado'=>'ACTIVO'))->result());
    }
    /*DESHABILITAR PRODUCTO*/
    public function eliminar_producto($id){
        $this->db->where('id',$id);
        return json_encode($this->db->update('producto',array('estado'=>'INACTIVO')));
    }

    public function editar_producto(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('editar_categorias_producto', 'categoria', 'trim');
        $this->form_validation->set_rules('editar_nombre_producto', 'nombre', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $id_producto = $this->input->post('id_producto');
            $obj_producto['categoria_id'] = $this->input->post('editar_categorias_producto');
            $obj_producto['nombre_producto'] = strtoupper($this->input->post('editar_nombre_producto'));

            $this->db->where('id',$id_producto);
            $response['success'] = $this->db->update('producto',$obj_producto);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }
}