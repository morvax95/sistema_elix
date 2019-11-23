<?php


class Model_categoria extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registrar_categoria(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('codigo_categoria', 'codigo', 'trim');
        $this->form_validation->set_rules('nombre_categoria', 'nombre', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $obj_categoria['codigo'] = $this->input->post('codigo_categoria');
            $obj_categoria['nombre_categoria'] = ucwords(strtolower($this->input->post('nombre_categoria')));
            $obj_categoria['estado'] = 'ACTIVO';

            $response['success'] = $this->db->insert('categoria',$obj_categoria);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }

    public function editar_categoria(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('editar_codigo_categoria', 'codigo', 'trim');
        $this->form_validation->set_rules('editar_nombre_categoria', 'nombre', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $id_categoria = $this->input->post('id_categoria');
            $obj_categoria['codigo'] = $this->input->post('editar_codigo_categoria');
            $obj_categoria['nombre_categoria'] = ucwords(strtolower($this->input->post('editar_nombre_categoria')));

            $this->db->where('id',$id_categoria);
            $response['success'] = $this->db->update('categoria',$obj_categoria);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($response);
    }

    public function eliminar_categoria($id){
        $this->db->where('id',$id);
        return $this->db->update('categoria',array('estado'=>'INACTIVO'));
    }

    public function get_categorias(){
        return $this->db->get_where('categoria',array('estado'=>'ACTIVO'))->result();
    }

    public function existe_categoria(){
        return $this->db->query("select count(*)cantidad from categoria where estado = 'ACTIVO'")->row();
    }
    public function obtenerCategoria()
    {
          return $this->db->get_where('categoria',array('estado'=>'ACTIVO'))->result();
    }
}