<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_actividad extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*----------------------------       FUNCION PARA REGISTRAR UNA NUEVA ACTIVIDAD        ---------------------------*/
    function registrarActividad($data){
        $this->db->trans_start();

        $this->db->insert('actividad', $data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'error';
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /*--------------------------------      FUNCION PARA MODIFICAR UNA ACTIVIDAD      --------------------------------*/
    function modificarActividad($id, $data){
        $this->db->where("id", $id);
        $res = $this->db->update("actividad", $data);
        return $res;
    }
    /*-----------------------------------     FUNCTION LISTAR ACTIVIDADES     ----------------------------------------*/
    function listarActividad(){

        $this->db->select('act.*, suc.sucursal')
            ->from('actividad AS act')
            ->join('sucursal AS suc','act.sucursal_id = suc.id')
            ->where('suc.estado',1)
            ->where('suc.id', get_id_sucursal_logueado());
        return $this->db->get()->result();

    }

    /*------------------- Funcion para deshabilitar una actividad seleccionada --------------*/
    public function eliminar($actividad){
        $this->db->where('id',$actividad);
        return $this->db->update('actividad',array('estado'=>0));
    }

    /*------------------- Funcion para habilitar una actividad seleccionada --------------*/
    public function habilitar($actividad){
        $this->db->where('id',$actividad);
        return $this->db->update('actividad',array('estado'=>1));
    }

    public function existenDatos(){
        return $this->db->query('select count(*)cant from actividad')->row();
    }
}