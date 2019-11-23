<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_impresora extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*------------------------------------------------
    * Funcion insertar los datos de la nueva impresora
    * -----------------------------------------------*/
    public function registrarImpresora($campos){
        return $this->db->insert('impresora',$campos);
    }

    /*-----------------------------------------------------------------
    * Funcion para actualizar los datos de una impresora seleccionada
     * Se envia los campos y el id como parametro
    * -----------------------------------------------------------------*/
    public function editarImpresora($campos,$id){
        $this->db->where('id',$id);
        return $this->db->update('impresora',$campos);
    }

    /*------------------------------------------------
    * Funcion para dar baja a impresora seleccionada
     * Se envia el id como parametro
    * -----------------------------------------------*/
    public function eliminar($id){
        $this->db->where('id',$id);
        return $this->db->update('impresora',array('estado'=>0));
    }

    /*------------------------------------------------
    * Funcion para habilitar la impresora seleccionada
     * Se envia el id como parametro
    * -----------------------------------------------*/
    public function habilitar($id){
        $this->db->where('id',$id);
        return $this->db->update('impresora',array('estado'=>1));
    }

    /*------------------------------------------------
    * Funcion para obtener la lista de impresoras
    * -----------------------------------------------*/
    public function obtenerImpresoras(){
        $this->db->select('imp.*, suc.sucursal')
            ->from('sucursal AS suc')
            ->join('impresora AS imp','suc.id=imp.sucursal_id')
            ->where('suc.id',get_id_sucursal_logueado());
        return $this->db->get()->result();
    }

    public function getImpresorasLogin($id_sucursal){
        $sql = "SELECT p.id, CONCAT_WS(p.marca,'',p.serial)AS marca FROM impresora p WHERE p.sucursal_id = ?";
        $res = $this->db->query($sql,array($id_sucursal))->result();
        return $res;
    }

    public function existenDatos(){
        return $this->db->query('select count(*)cant from impresora')->row();
    }
}