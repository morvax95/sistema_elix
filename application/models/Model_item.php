<?php

/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 26/05/2017
 * Time: 09:53 AM
 */
class Model_item extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registrar_item(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
//        $this->form_validation->set_rules('codigo_barras', 'codigo de barras', 'trim');
        $this->form_validation->set_rules('nombre_item', 'nombre de item', 'trim|required');
        $this->form_validation->set_rules('precio_venta', 'precio de venta', 'trim|required');
        $this->form_validation->set_rules('tamaño', 'tamaño', 'trim');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
//            $obj_item['codigo_barra'] = trim($this->input->post('codigo_barras'));
//            $obj_item['codigo_alterno'] = trim($this->input->post('codigo_alterno'));
            $obj_item['codigo_barra']   = 0;
            $obj_item['nombre_item']    = ucwords(strtolower($this->input->post('nombre_item')));
            $obj_item['precio_venta']   = $this->input->post('precio_venta');
            $obj_item['tamaño']         = $this->input->post('tamaño');
            $obj_item['stock']          = 0;
            $obj_item['fecha_registro'] = date('Y-m-d');
            $obj_item['categoria_id']   = $this->input->post('categorias');
            $obj_item['estado'] = 'ACTIVO';

            $response['success'] = $this->db->insert('item',$obj_item);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }

    public function editar_item(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('editar_nombre_item', 'nombre de item', 'trim|required');
        $this->form_validation->set_rules('editar_precio_venta', 'precio de venta', 'trim|required');
        $this->form_validation->set_rules('tamaño', 'tamaño', 'trim');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $obj_item['codigo_barra']   = 0;
            $obj_item['nombre_item']    = ucwords(strtolower($this->input->post('editar_nombre_item')));
            $obj_item['precio_venta']   = $this->input->post('editar_precio_venta');
            $obj_item['tamaño']         = $this->input->post('editar_tamaño');
            $obj_item['stock']          = 0;
            $obj_item['fecha_registro'] = date('Y-m-d');
            $obj_item['categoria_id']   = $this->input->post('editar_categorias');

            $this->db->where('id',$this->input->post('id_item'));
            $response['success'] = $this->db->update('item',$obj_item);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }

    function get_lista_item(){
        $this->db->select('i.id, i.nombre_item, i.precio_venta, i.tamaño, i.estado, c.id as categoria_id, c.nombre_categoria');
        $this->db->from('item i, categoria c');
        $this->db->where('i.categoria_id = c.id');
        $this->db->where("i.estado = 'ACTIVO' and c.estado = 'ACTIVO'");
        return $this->db->get()->result();
    }

    function get_item($id){
        return $this->db->get_where('item',array('categoria_id'=>$id))->result();
    }

    public function eliminar($id){
        $this->db->where('id',$id);
        return $this->db->update('item',array('estado'=>'INACTIVO'));
    }
}