<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_consultar_venta extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_lista_factura_server_side($start, $length, $search)
    {
        $sql_search = "";
        if ($search){
            $sql_search = "AND f.fecha LIKE '%".$search."%' AND f.nro_factura LIKE '%".$search."%' or f.autorizacion LIKE '%".$search."%' 
            and f.nombre_cliente LIKE '%".$search."%' ";
        }

        $sesion = $this->session->userdata('usuario_sesion');
        $sql_count = "SELECT count(1)cantidad
                FROM factura_datos f
                WHERE f.sucursal_id = ? ".$sql_search;
        $data_sql = $this->db->query($sql_count,array($sesion['idSucursal']))->row();
        $cantidad_facturas = $data_sql->cantidad;


        $sql = "SELECT f.venta_id as id, f.nro_factura, DATE_FORMAT(f.fecha,'%d/%m/%Y') as fecha_transaccion, f.autorizacion, f.monto_total, f.nombre_cliente
                FROM factura_datos f
                WHERE f.sucursal_id = ? ".$sql_search." LIMIT $start, $length ";
        $respuesta = $this->db->query($sql,array($sesion['idSucursal']));

        $resultados = array(
            'total' => $cantidad_facturas,
            'datos' => $respuesta,
        );

        return $resultados;
    }

    public function obtener_lista_factura()
    {
        $sesion = $this->session->userdata('usuario_sesion');
        $sql = "SELECT v.id, f.nro_factura,f.fecha as fecha_transaccion, d.autorizacion, f.monto_total, cl.nombre_cliente
                FROM venta v , factura f, cliente cl, dosificacion d
                WHERE v.id = f.venta_id AND v.cliente_id = cl.id AND f.dosificacion_id = d.id AND v.sucursal_id = ?";
        return $this->db->query($sql,array($sesion['idSucursal']))->result();
    }

    public function anularFactura($id)
    {
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->update('venta',array('cliente_id'=> 2));

        $datos['estado'] = 'A';
        $datos['monto_total'] = '0.00';
        $datos['importe_ice'] = '0.00';
        $datos['importe_excento'] = '0.00';
        $datos['subtotal'] = '0.00';
        $datos['descuento'] = '0.00';
        $datos['importe_base'] = '0.00';
        $datos['debito_fiscal'] = '0.00';

        $this->db->where('venta_id', $id);
        $this->db->update('factura', $datos);

        $datos['nit_cliente'] = 0;
        $datos['nombre_cliente'] = 'ANULADO';
        $this->db->where('venta_id', $id);
        $this->db->update('factura_datos', $datos);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'error';
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

}