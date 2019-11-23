<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_cliente extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*----- Obtiene a todos los clientes de la tabla -------*/
    public function listar_clientes(){
        return $this->db->get_where('cliente',array('estado'=>1))->result();
    }
    public function listar_clientes_server_side($start, $length, $search){

        $sql_search = "";
        if ($search){
            $sql_search = "AND c.ci_nit LIKE '%".$search."%' or c.nombre_cliente LIKE '%".$search."%' ";
        }

        $sql_cantidad = "select count(1)cantidad from cliente c WHERE c.estado = 1 ".$sql_search;
        $data_sql = $this->db->query($sql_cantidad)->row();
        $cantidad_clientes = $data_sql->cantidad;

        $sql = "select c.id, c.ci_nit, c.nombre_cliente, c.telefono, c.direccion, c.email, c.estado 
                from cliente c WHERE c.estado = 1 " . $sql_search ." LIMIT $start, $length ";

        $res = $this->db->query($sql);
        $resultados = array(
            'total' => $cantidad_clientes,
            'datos' => $res,
        );

        return $resultados;
    }

    /*------ Metodo para registrar un nuevo cliente--------*/
    public function registrar_cliente($cliente){
        return $this->db->insert('cliente',$cliente);
    }

    /*------ Metodo para actualizar datos de un cliente--------*/
    public function editarCliente($cliente,$id){
        $this->db->where('id',$id);
        return $this->db->update('cliente',$cliente);
    }
    /*------ Metodo para deshabilitar al cliente seleccionado ----------*/
    public function eliminar($id){
        $this->db->where('id',$id);
        return $this->db->update('cliente',array('estado'=>0));
    }

    /*------ Metodo para habilitar al cliente seleccionado ----------*/
    public function habilitar($id){
        $this->db->where('id',$id);
        return $this->db->update('cliente',array('estado'=>1));
    }

    /*-------------------------------------------------------------------
    * Metodo llamado en la funcion registroVenta para extraer al cliente PARTICULAR en casco
    * de que el usuario no haya puesto datos del cliente en formulario
    * **/
    public function obtener_cliente_particular(){
        return $this->db->get_where('cliente',array('id'=>1))->row();
    }

    public function exite_cliente($nitCliente){
        $resultado = $this->db->get_where('cliente',array('ci_nit'=>$nitCliente));
        if($resultado->num_rows()>0){
            // Si esta registrado
            return true;
        }else{
            // No esta registrado
            return false;
        }
    }

    public function registrar_cliente_venta($cliente){
        $this->db->insert('cliente',$cliente);

        $res = $this->db->get_where('cliente',array('ci_nit' =>$cliente['ci_nit'],'nombre_cliente'=> $cliente['nombre_cliente']))->row();
r4g0n
        return $res->id;
    }


 
}