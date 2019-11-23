<?php

class Model_inicio extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerAvisos(){
        // Aviso de la dosificacion
        $this->load->model('model_dosificacion','md');
        $datos['dosificacion'] = $this->md->tiempoRestanteDosificacion();

        return $datos;
    }

    public function cargar_menu($usuario_id, $cargo)
    {
        if ($cargo != 'ADMINISTRADOR') {
            $sql = "SELECT m.* 
                FROM menu m, acceso a, usuario u 
                WHERE m.id = a.menu_id and 
                      a.usuario_id = u.id and 
                      u.id = ? ORDER BY m.id";
            return $this->db->query($sql,$usuario_id)->result_array();
        } else {
            return $this->db->get('menu')->result_array();
        }
    }

    public function verificar($id)
    {
        $res = $this->db->get_where('usuario', array('id' => $id));
        return $res->row();
    }

    public function confirma_cambio($idUsuario, $claveNueva)
    {
        $claveEncriptada = password_hash($claveNueva,PASSWORD_BCRYPT);
        $datos = array(
            'clave'=>$claveEncriptada
        );
        $this->db->where('id',$idUsuario);
        $res = $this->db->update('usuario',$datos);
        return $res;
    }
}