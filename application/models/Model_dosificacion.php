<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*----------------------------------------    ESTADOS PARA LA DOSIFICACION     ---------------------------------------*/
/*
 * ESTADO = INACTIVO (defecto al registrar)
 * ESTADO = ACTIVO
 * ESTADO = CADUCADO
 *
 * -------------------------------------------------------------------------------------------------------------------*/

class Model_dosificacion extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function registrarDosificacion($data){
        $this->db->trans_start();
        // Registramos la dosificacion
        $sesion = $this->session->userdata('usuario_sesion');
        $datos = array(
            'autorizacion'      => $data['autorizacion'],
            'nro_inicio'        => $data['nro_inicio'],
            'llave'             => $data['llave'],
            'fecha_limite'      => $data['fecha_limite'],
            'leyenda'           => $data['leyenda'],
            'fecha_registro'    => $data['fecha_registro'],
            'actividad_id'      => $data['actividad'],
            'impresora_id'      => $data['impresora'],
            'sucursal_id'       => $sesion['idSucursal']
        );
        $this->db->insert("dosificacion", $datos);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 'error';
        } else {
            $this->db->trans_commit();
            return 'true';
        }

    }
    /*--------------------------      FUNCION PARA LISTAR LAS DOSIFICACIONES ACTIVAS        --------------------------*/
    function obtenerDosificaciones(){
        $sesion = $this->session->userdata('usuario_sesion');
        $sucursal_id = $sesion['idSucursal'];
        $this->db->select('d.id,d.autorizacion,d.fecha_limite,d.estado, a.nombre_actividad, CONCAT_WS(\' \',i.marca,\'\',i.serial)as impresora ,s.sucursal')
            ->from('dosificacion AS d')
            ->join('impresora AS i','i.id = d.impresora_id')
            ->join('actividad AS a', 'a.id = d.actividad_id')
            ->join('sucursal AS s', 's.id = a.sucursal_id')
            ->where('d.sucursal_id',$sucursal_id)
            ->order_by('d.id','DESC');

        return $this->db->get()->result();
    }

    /*-----------------------------     FUNCION PARA ELIMINAR UNA DOSIFICACION       ---------------------------------*/
    function eliminarDosificacion($id){
        $this->db->where("id", $id);
        $estado = array("estado" => 0);
        return $this->db->update('dosificacion', $estado);
    }

    /*-----------------------------     FUNCION PARA REACTIVAR UNA DOSIFICACION       --------------------------------*/
    function reactivarDosificacion($id){
        $this->db->where("id", $id);
        $estado = array("estado" => 1);
        return $this->db->update('dosificacion', $estado);
    }

    /*-----------------------    FUNCION PARA CALCULAR EL TIEMPO RESTANTE DE UNA DOSIFICACION      ------------------*/
    function tiempoRestanteDosificacion(){
        $sesion = $this->session->userdata('usuario_sesion');
        $con = "SELECT d.id, d.autorizacion, d.fecha_limite
                FROM actividad a, dosificacion d, impresora i
                WHERE a.id = d.actividad_id and d.impresora_id = i.id and d.estado = 'ACTIVO' and a.estado = 1 and i.estado = 1 and d.sucursal_id = ?";
        $res = $this->db->query($con,array($sesion['idSucursal']));

        $mensaje = "";
        $color = "bg-green";
        $info_dosificacion = [];
        if($res->num_rows()>0) {
            foreach ($res->result() as $datos) {

                $fecha_limite = $datos->fecha_limite;

                $fecha_actual = date('Y-m-d');

                $diferencia_fecha = strtotime($fecha_limite) - strtotime($fecha_actual);
                $diasRestantes = intval($diferencia_fecha / 60 / 60 / 24);
                $obj_dosificacion = [];
                $diasRestantes = $diasRestantes +1;
                switch ($diasRestantes) {
                    case ($diasRestantes == 0): // No activas
                        $obj_dosificacion['autorizacion'] = $datos->autorizacion. 'ha caducado.';
                        $obj_dosificacion['mensaje'] = "Por favor registre una nueva.";
                        $obj_dosificacion['color'] = 'bg-red';
                        $obj_dosificacion['dias'] = 'La dosificacion Nro.';
                        $this->caducar_dosificacion($datos->id);
                        break;
                    case ($diasRestantes > 0 && $diasRestantes <= 10): // Faltando 10 dias
                        $obj_dosificacion['autorizacion'] = 'Dias a la dosificacion '.$datos->autorizacion;
                        $obj_dosificacion['color'] = 'bg-red';
                        $obj_dosificacion['mensaje'] = "Por vencer";
                        $obj_dosificacion['dias'] = 'Le quedan: '.$diasRestantes;
                        break;
                    case ($diasRestantes > 10):
                        $obj_dosificacion['autorizacion'] = 'Dias a la dosificacion '.$datos->autorizacion;
                        $obj_dosificacion['mensaje'] = "Activa";
                        $obj_dosificacion['color'] = 'bg-green';
                        $obj_dosificacion['dias'] = 'Le quedan: '.$diasRestantes;
                        break;
                    case ($diasRestantes <= 0):
                        $obj_dosificacion['autorizacion'] = $datos->autorizacion. 'ha caducado.';
                        $obj_dosificacion['mensaje'] = "Por favor registre una nueva.";
                        $obj_dosificacion['color'] = 'bg-red';
                        $obj_dosificacion['dias'] = 'La dosificacion Nro.';
                        $this->caducar_dosificacion($datos->id);
                        break;
                }
                $info_dosificacion[] = $obj_dosificacion;
            }
        }else{
            $obj_dosificacion['autorizacion'] = '';
            $obj_dosificacion['mensaje'] = "Registre al menos una dosificacion, asignando una impresora y actividad economica.";
            $obj_dosificacion['color'] = 'bg-red';
            $obj_dosificacion['dias'] = 'ESTA SUCURSAL NO CUENTA CON UNA DOSIFICACION ACTIVA';
            $info_dosificacion[] = $obj_dosificacion;
        }
        return  $info_dosificacion;
    }

    /*------------------------------       FUNCION PARA ACTIVAR UNA DOSIFICACION       -------------------------------*/
    function activar($id){
        /*Desactivamos las demas dosificaciones de desta sucursal   */
        $this->db->where('id!=',$id)
            ->where('sucursal_id', get_id_sucursal_logueado())
            ->update('dosificacion',array('estado' => 'INACTIVO'));

        $this->db->where("id", $id);
        return $this->db->update("dosificacion", array('estado'=>'ACTIVO'));
    }

    /*------------------------------      FUNCION PARA CADUCAR UNA DOSIFICACION        -------------------------------*/
    function caducar_dosificacion($id){
        $this->db->where("id", $id);
        $res = $this->db->update("dosificacion", $estado = array("estado" => 'CADUCADO'));
        return $res;
    }

    function verificar_doficacion_activa($id_sucursal,$id_impresora){
        $sql_verificar = "select count(*)cantidad from dosificacion d where d.estado = 'ACTIVO' and d.sucursal_id = ? and d.impresora_id = ?";
        $respuesta = $this->db->query($sql_verificar,array($id_sucursal,$id_impresora))->row()->cantidad;
        return $respuesta;
    }
}
?>