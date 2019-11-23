<?php
class Model_reporte extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFacturasLCV($mes, $anio,$sucursal){
        $sql = "SELECT v.id, d.autorizacion, DATE_FORMAT(f.fecha,'%d/%m/%Y')as fecha, f.nro_factura,f.monto_total,f.importe_ice,f.importe_excento,f.ventas_grabadas_taza_cero,f.subtotal,f.descuento,f.importe_base,f.debito_fiscal,f.codigo_control,f.estado, s.nit,s.sucursal, c.ci_nit, c. nombre_cliente
                FROM cliente c, venta v, factura f, dosificacion d, actividad a, sucursal s
                WHERE c.id = v.cliente_id and v.id = f.venta_id and f.dosificacion_id = d.id and d.actividad_id = a.id and a.sucursal_id = s.id and date_format(f.fecha, '%m') = ? and date_format(f.fecha, '%Y') = ? and s.id  = ? ORDER by f.nro_factura ASC ";
        $respuesta = $this->db->query($sql,array($mes,$anio,$sucursal))->result();
        return $respuesta;
    }
    
    public function getClientes(){
        $sql = "SELECT *
                FROM cliente c";
        $respuesta = $this->db->query($sql,array())->result();
        return $respuesta;
    }
    public function getProductos($categoria){
        $sql = "select i.id,i.nombre_item as producto,i.precio_venta as precio,i.estado,c.nombre_categoria as categoria from item i inner join categoria c on c.id=i.categoria_id where i.categoria_id= ?" ;
        $respuesta = $this->db->query($sql,array($categoria))->result();
        return $respuesta;
    }
    public function getListaProductos(){
        $sql = "select i.id,i.nombre_item as producto,i.precio_venta as precio,i.estado,c.nombre_categoria as categoria from item i inner join categoria c on c.id=i.categoria_id " ;
        $respuesta = $this->db->query($sql,array())->result();
        return $respuesta;
    }
    public function getNitEmpresa(){
        return $this->db->get('sucursal')->row();
    }

    /*--------------------------------------------------------------------------------------------
     * Metodos para el reporte de ventas por cliente
     * **/
    public function getVentasCliente($fecha_inicio, $fecha_fin){
        $sql = "SELECT v.id, v.fecha, v.subtotal,v.descuento,v.total,c.ci_nit,c.nombre_cliente, SUM(d.cantidad)cantidad
                FROM cliente c, venta v, detalle_venta d 
                WHERE c.id = v.cliente_id and v.id = d.venta_id and c.id != 1 and c.id != 2 and v.tipo_venta != 'PROFORMA' and v.tipo_transaccion = 'MATERIA' and v.estado = 1 AND v.fecha >= ? and v.fecha <= ?
                GROUP by v.id
                ORDER BY v.id ASC";
        $respuesta = $this->db->query($sql,array($fecha_inicio, $fecha_fin))->result();
        return $respuesta;
    }

  
}