<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_venta extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function next_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'venta' ";
        $res = $this->db->query($sql);
        return $res->row()->Auto_increment;
    }

    // Registra una nueva venta
    public function registrar_venta()
    {
        $response['success'] = false;
        $response['message'] = null;

        $this->db->trans_start();

        // Verificamos el cliente ingresado
        $this->load->model('model_cliente');
        if ($this->input->post('nit_cliente') === '' or $this->input->post('nit_cliente') === '0') {
            $datosCliente = $this->model_cliente->obtener_cliente_particular();
            $idCliente = $datosCliente->id;
        }else{
            if($this->input->post('nombre_cliente') === ''){
                $this->db->trans_rollback();
                return 'error';
            }else{
                // Verificamos si el cliente ingresado (NIT) se encuentra registrado,
                // En caso que no estuviera se lo registra.
                if ($this->model_cliente->exite_cliente(trim($this->input->post('nit_cliente')))) {
                    $idCliente = $this->input->post('idCliente');
                } else {
                    $cliente['ci_nit'] = trim($this->input->post('nit_cliente'));
                    $cliente['nombre_cliente'] = trim($this->input->post('nombre_cliente'));
                    $idCliente = $this->model_cliente->registrar_cliente_venta($cliente);
                }
            }
        }

        // Obtenemos los datos de la venta
        $sesion = $this->session->userdata('usuario_sesion');
        $obj_venta['fecha'] = date('Y-m-d');
        $obj_venta['subtotal'] = $this->input->post('subtotal_as');
        $obj_venta['descuento'] = $this->input->post('descuento_as');
        $obj_venta['total'] = $this->input->post('total_as');
        $obj_venta['cliente_id'] = $idCliente;
        $obj_venta['sucursal_id'] = $sesion['idSucursal'];
        $obj_venta['usuario_id'] = $sesion['idUsuario'];
        $obj_venta['estado'] = 1;


        $this->db->insert('venta', $obj_venta);
        // Obtenemos el id insertado
        $id_venta = $this->next_id() - 1;

        // Obtenemos las variables para el detalle
        $detalle['item_id'] = $this->input->post('id_item[]');
        $detalle['cantidad'] = $this->input->post('cantidad[]');
        $detalle['precio'] = $this->input->post('precio[]');

        for ($index = 0; $index < count($detalle['item_id']); $index++) {
            if( $detalle['cantidad'][$index]!=0){
                $obj_detalle['venta_id'] = $id_venta;
                $obj_detalle['item_id'] = $detalle['item_id'][$index];
                $obj_detalle['cantidad'] = $detalle['cantidad'][$index];
                $obj_detalle['precio_venta'] = $detalle['precio'][$index];

                $this->db->insert('detalle_venta', $obj_detalle);
            }

        }
        // Factura
        $this->registrarFactura($id_venta, $obj_venta);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'error';
        } else {
            $this->db->trans_commit();
            $this->db->truncate('item_agregado');
            $response['success'] = true;
            $response['message'] = $id_venta;
            return $response;
        }
    }

    public function imprimirFactura($idVenta)
    {
        //Datos genericos de la factura
        $sql_datos_factura = "SELECT v.id, f.fecha,f.nro_factura,f.monto_total,f.importe_ice,f.importe_excento,f.ventas_grabadas_taza_cero,f.subtotal,f.descuento,f.importe_base,f.debito_fiscal,
                              f.codigo_control,f.estado, d.autorizacion, d.fecha_limite, d.leyenda, a.nombre_actividad,a.direccion, a.telefono, a.celular, a.email, c.ci_nit, c.nombre_cliente, s.nit, s.nombre_empresa,s.sucursal
                              FROM cliente c, venta v, factura f, dosificacion d, actividad a, sucursal s
                              WHERE c.id = v.cliente_id and v.id = f.venta_id and f.dosificacion_id = d.id and d.actividad_id = a.id AND a.sucursal_id = s.id AND v.id = ?";
        $datos_factura = $this->db->query($sql_datos_factura, $idVenta)->row();
        $datos_array['datos_factura'] = $datos_factura;
        $datos_array['datos_venta_detalle'] = $this->obtenerDetalleVenta($idVenta);

        $qr['id_venta'] = $datos_factura->id;
        $qr['nit_empresa'] = $datos_factura->nit;
        $qr['empresa'] = $datos_factura->nombre_empresa;
        $qr['nit_cliente'] = $datos_factura->ci_nit;
        $qr['nombre_cliente'] = $datos_factura->nombre_cliente;
        $qr['fecha_trans'] = $datos_factura->fecha;
        $qr['autorizacion'] = $datos_factura->autorizacion;
        $qr['nro_factura'] = $datos_factura->nro_factura;
        $qr['total'] = $datos_factura->monto_total;
        $qr['subtotal'] = $datos_factura->subtotal;
        $qr['descuento'] = $datos_factura->descuento;
        $qr['importe_base'] = $datos_factura->importe_base;
        $qr['debito'] = $datos_factura->debito_fiscal;
        $qr['codigo'] = $datos_factura->codigo_control;
        $qr['estado'] = $datos_factura->estado;

        $datos_array['qr_image'] = $this->generarQR($qr);


        return $datos_array;
    }

    public function adicionar()
    {
        $datos['item_id'] = $this->input->post('item');
        $datos['categoria_id'] = $this->input->post('categoria');
        $datos['usuario_id'] = $this->input->post('usuario');
        $datos['sucursal_id'] = $this->input->post('sucursal');
        $contador = $this->input->post('contador');


        $this->db->select('cantidad');
        $this->db->from('item_agregado');
        $this->db->where('item_id', $datos['item_id']);
        $this->db->where('categoria_id', $datos['categoria_id']);
        $this->db->where('usuario_id', $datos['usuario_id']);
        $this->db->where('sucursal_id', $datos['sucursal_id']);
        $cantidad_agregada = $this->db->get()->row();

        if($cantidad_agregada !=null){
            $cantidad = $cantidad_agregada->cantidad + 1;
            $datos['cantidad'] = $cantidad;

            $this->db->where('item_id', $datos['item_id']);
            $this->db->where('categoria_id', $datos['categoria_id']);
            $this->db->where('usuario_id', $datos['usuario_id']);
            $this->db->where('sucursal_id', $datos['sucursal_id']);
            $this->db->update('item_agregado', array('cantidad'=>$datos['cantidad']));
            $respuesta['contador']=$contador;
        }else{
            $this->db->insert('item_agregado', $datos);
            $respuesta['contador']=$contador+1;
        }

        $this->db->select('i.id, i.nombre_item, i.precio_venta, i.categoria_id, a.cantidad, a.usuario_id, a.sucursal_id');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $this->db->group_by('i.id');
        $respuesta['agregados'] = $this->db->get()->result();

        $this->db->select('SUM(i.precio_venta * a.cantidad)as total');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $respuesta['total'] = $this->db->get()->result();

        return json_encode($respuesta);
    }

    public function disminuir()
    {
        $datos['item_id'] = $this->input->post('item');
        $datos['categoria_id'] = $this->input->post('categoria');
        $datos['usuario_id'] = $this->input->post('usuario');
        $datos['sucursal_id'] = $this->input->post('sucursal');
        $contador = $this->input->post('contador');
        $respuesta['contador']=$contador;

        $this->db->select('cantidad');
        $this->db->from('item_agregado');
        $this->db->where('item_id', $datos['item_id']);
        $this->db->where('categoria_id', $datos['categoria_id']);
        $this->db->where('usuario_id', $datos['usuario_id']);
        $this->db->where('sucursal_id', $datos['sucursal_id']);
        $cantidad_agregada = $this->db->get()->row();
        if($cantidad_agregada->cantidad > 1){
            $cantidad = $cantidad_agregada->cantidad;
            $datos['cantidad'] = $cantidad - 1;

            $this->db->where('item_id', $datos['item_id']);
            $this->db->where('categoria_id', $datos['categoria_id']);
            $this->db->where('usuario_id', $datos['usuario_id']);
            $this->db->where('sucursal_id', $datos['sucursal_id']);
            $this->db->update('item_agregado', array('cantidad'=>$datos['cantidad']));
            $respuesta['contador']=$contador;
        }else{
            $this->db->where($datos);
            $this->db->limit(1);
            $this->db->delete('item_agregado');
            $respuesta['contador']=$contador;
        }



        $this->db->select('i.id, i.nombre_item, i.precio_venta, i.categoria_id, a.cantidad, a.usuario_id, a.sucursal_id');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $this->db->group_by('i.id');
        $respuesta['agregados'] = $this->db->get()->result();

        $this->db->select('SUM(i.precio_venta * a.cantidad)as total');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $respuesta['total'] = $this->db->get()->result();

        return json_encode($respuesta);
    }

    public function adicionar_cantidad()
    {
        $datos['item_id'] = $this->input->post('item');
        $datos['categoria_id'] = $this->input->post('categoria');
        $datos['usuario_id'] = $this->input->post('usuario');
        $datos['sucursal_id'] = $this->input->post('sucursal');
        $cantidad = $this->input->post('cantidad');

            $this->db->where('item_id', $datos['item_id']);
            $this->db->where('categoria_id', $datos['categoria_id']);
            $this->db->where('usuario_id', $datos['usuario_id']);
            $this->db->where('sucursal_id', $datos['sucursal_id']);
            $this->db->update('item_agregado', array('cantidad'=>$cantidad));

        $this->db->select('i.id, i.nombre_item, i.precio_venta, i.categoria_id, a.cantidad, a.usuario_id, a.sucursal_id');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $this->db->group_by('i.id');
        $respuesta['agregados'] = $this->db->get()->result();

        $this->db->select('SUM(i.precio_venta * a.cantidad)as total');
        $this->db->from('item_agregado a, item i');
        $this->db->where('a.item_id = i.id');
        $respuesta['total'] = $this->db->get()->result();

        return json_encode($respuesta);
    }

    function obtenerDetalleVenta($idventa)
    {
        $sql_datos_venta_2 = "SELECT v.id, i.nombre_item, i.tamaño,d.precio_venta,d.cantidad, c.nombre_categoria
                              FROM venta v, detalle_venta d, item i, categoria c
                              WHERE v.id = d.venta_id and d.item_id = i.id and i.categoria_id = c.id and v.id = ?";
        $res_datos_venta_1 = $this->db->query($sql_datos_venta_2, $idventa)->result();

        return $res_datos_venta_1;
    }


    /*----------------------------------------------------------
     * Registro de la factura y los datos asociados
     * ----------------------------------------------------------*/
    public function registrarFactura($id_venta, $datos)
    {
        $this->db->trans_start();

        // Consultamos el nit de la venta del cliente
        $query_cliente = "select ci_nit,nombre_cliente from cliente WHERE id = ?";
        $datosCliente = $this->db->query($query_cliente, $datos['cliente_id'])->row();
        $nit_cliente = trim($datosCliente->ci_nit);
        $nombre_cliente = $datosCliente->nombre_cliente;

        $sesion = $this->session->userdata('usuario_sesion');
        //Consulta a dosificacion                                                               //Verificamos con la actividad seteada en la sesion
        $datosDosificacion = $this->db->query("select id,autorizacion,llave from dosificacion where estado = 'ACTIVO' and sucursal_id = ? AND impresora_id = ?", array($sesion['idSucursal'], $sesion['id_impresora']))->row();
        $dosificacion_id = $datosDosificacion->id;
        $dosificacion_autorizacion = trim($datosDosificacion->autorizacion);
        $dosificacion_llave = $datosDosificacion->llave;

        // Verificamos si existe factura
        $sql = "select count(nro_factura)as cantidad from factura where dosificacion_id = ?";
        $nro_factura = $this->db->query($sql, array($dosificacion_id))->row()->cantidad;
        if ($nro_factura === '0' or $nro_factura === 0) {
            $query = "select nro_inicio from dosificacion where id = ?";
            $datoNro = $this->db->query($query, $dosificacion_id)->row();
            $nro_factura = trim($datoNro->nro_inicio);
        } else {
            $sql = "select max(nro_factura)as nro from factura where dosificacion_id = ?";
            $nro_factura = $this->db->query($sql, array($dosificacion_id))->row()->nro;
            $nro_factura++;
        }
        $datos['fecha'] = date('Y-m-d');

        include APPPATH . '/libraries/CodigoControl.class.php';
        //Formateamos la fecha para que quede sin separadores
        $anio = substr($datos['fecha'], 0, 4);
        $mes = substr($datos['fecha'], 5, 2);
        $dia = substr($datos['fecha'], 8);
        $fechaFormateada = $anio . $mes . $dia;
        // Formateamos el total para que se aplique o no el redondeo
        $datosMonto = explode(".", $datos['total']); // DIVIDO EL MONTO A PAGAR PARA EXTRAER LA PARTE ENTERA Y LA PARTE DECIMAL
        $entero = $datosMonto[0];
        $decimal = @$datosMonto[1];
        if ($decimal >= 50) {
            $entero = $entero + 1;
        }
        $crear_codigo = new CodigoControl(
            $dosificacion_autorizacion, $nro_factura, $nit_cliente, $fechaFormateada, $entero, $dosificacion_llave
        );

        $codigo_control = $crear_codigo->generar();

        // Insertamos los datos de la factura
        $factura['venta_id'] = $id_venta;
        $factura['dosificacion_id'] = $dosificacion_id;
        $factura['fecha'] = $fechaFormateada;
        $factura['nro_factura'] = $nro_factura;
        $factura['monto_total'] = $datos['total'];
        $factura['subtotal'] = $datos['subtotal'];
        $factura['descuento'] = $datos['descuento'];
        $factura['importe_base'] = ($datos['total'] - $datos['descuento']);
        $factura['debito_fiscal'] = ($datos['total'] - $datos['descuento']) * 0.13;
        $factura['codigo_control'] = $codigo_control;
        $factura['estado'] = 'V';
        $this->db->insert('factura', $factura);

        $factura_datos['venta_id'] = $id_venta;
        $factura_datos['autorizacion'] = $dosificacion_autorizacion;
        $factura_datos['nit_cliente'] = $nit_cliente;
        $factura_datos['nombre_cliente'] = $nombre_cliente;
        $factura_datos['fecha'] = $fechaFormateada;
        $factura_datos['nro_factura'] = $nro_factura;
        $factura_datos['monto_total'] = $datos['subtotal'];
        $factura_datos['subtotal'] = $datos['subtotal'];
        $factura_datos['descuento'] = $datos['descuento'];
        $factura_datos['importe_base'] = ($datos['total'] - $datos['descuento']);
        $factura_datos['debito_fiscal'] = ($datos['total'] - $datos['descuento']) * 0.13;
        $factura_datos['codigo_control'] = $codigo_control;
        $factura_datos['estado'] = 'V';
        $factura_datos['sucursal_id'] = $sesion['idSucursal'];
        $factura_datos['usuario_id'] = $sesion['idUsuario'];

        $this->db->insert('factura_datos', $factura_datos);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'error';
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function generarQR($datos)
    {
        $PNG_TEMP_DIR = 'assets/temp/';

        //html PNG location prefix
        $PNG_WEB_DIR = 'assets/temp/';

        include APPPATH . '/libraries/qrcode/qrlib.php';
        //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);
        $errorCorrectionLevel = 'L';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H')))
            $errorCorrectionLevel = $_REQUEST['level'];

        $matrixPointSize = 3;
        if (isset($_REQUEST['size']))
            $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        $filename = $PNG_TEMP_DIR . 'test' . $datos['id_venta'] . $datos['nro_factura'] . '.png';
        $datos = $datos['nit_empresa'] .'|'. $datos['nro_factura'] .'|'. $datos['autorizacion'] . '|' . $datos['fecha_trans'] . "|" . $datos['total'] .
            '|' . $datos['importe_base'] . '|' . $datos['codigo'] . "|" . $datos['nit_cliente'] . '|0|0|0|' .
            $datos['descuento'];

        QRcode::png($datos, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        return $PNG_WEB_DIR . basename($filename);
    }
}