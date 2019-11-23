<?php

class Model_login extends CI_Model
{

    public function maxInicio()
    {
        $sql = "SHOW TABLE STATUS LIKE 'inicio_sesion'";
        $res = $this->db->query($sql);
        return $res->row()->Auto_increment;
    }

    public function login($nombre_usuario, $pass, $idSucursal)
    {
        $sql_verifica = "SELECT u.id, u.ci, u.nombre_usuario, u.estado, u.telefono, u.cargo, u.clave FROM usuario u  WHERE u.usuario = ?";
        $datos_usuario = $this->db->query($sql_verifica, array($nombre_usuario));
        if ($datos_usuario->num_rows() > 0) {
            $cargo_usuario = $datos_usuario->row()->cargo;
            if ($cargo_usuario != 'ADMINISTRADOR') {
                $sql = "SELECT u.id, u.ci, u.nombre_usuario, u.estado, u.telefono, u.cargo, u.clave 
                FROM usuario u, usuario_sucursal us, sucursal s 
                WHERE u.id = us.usuario_id and us.sucursal_id = s.id and u.usuario = ? and s.id = ?";
                $resultado = $this->db->query($sql, array($nombre_usuario, $idSucursal));
            } else {
                $resultado = $this->db->query($sql_verifica, array($nombre_usuario));
            }
            if($resultado->num_rows()>0){
                $usuario = $resultado->row();
                if (password_verify($pass, $usuario->clave)) { //Verifica si la clave ingresada es correcta
                    $this->load->model('model_inicio');
                    // Verificar estado del usuario
                    if ($usuario->estado === '1') {
                        //Verificamos si la sesion esta activa
                        if ($this->sesionActiva($usuario->id)) {
                            $this->obtnerSesionActiva($usuario->id, $idSucursal);
                            $menu = $this->model_inicio->cargar_menu($usuario->id, $usuario->cargo);
                            $this->session->set_userdata('menu', $menu);
                            return 'sesion';
                        } else {
                            // Registrar la informacion necesaria en sesion
                            $this->set_sesion_usuario($usuario, $idSucursal);

                            $menu = $this->model_inicio->cargar_menu($usuario->id, $usuario->cargo);
                            $this->session->set_userdata('menu', $menu);
                            return TRUE;
                        }
                    } else {
                        return 'error2'; // Usuario inhabilitado
                    }
                } else {
                    return 'error1'; // Datos incorrectos
                }
            }else{
                return 'error3'; // Usuario no esta asignado a sucursal
            }
        } else {
            return 'error1'; // Usuario no existe o datos incorrectos
        }
    }

    /** Metodo que sobre escribe la sesion usuario_sesion para incorporar el id de la impresora */
    public function inicio_sesion($idU, $idImpresora, $marca)
    {
        $this->session->set_userdata('logueado', true);
        $sesion = $this->session->userdata('usuario_sesion');
        $this->db->insert('inicio_sesion', array('fecha' => date('Y-m-d H:i:s'), 'usuario_id' => $idU, 'impresora_id' => $idImpresora));

        $idInicioSesion = $this->maxInicio() - 1;
        $nombre_sucursal = $this->db->get_where('sucursal', array('id' => $sesion['sucursal']))->row()->sucursal;
        $usuario_sesion = array(
            'idSesion' => $idInicioSesion,
            'idUsuario' => $sesion['id'],
            'ci' => $sesion['ci'],
            'nombre' => $sesion['nombre'],
            'cargo' => $sesion['cargo'],
            'telf' => $sesion['telf'],
            'id_impresora' => $idImpresora,
            'marca' => $marca,
            'idSucursal' => $sesion['sucursal'],
            'nombre_sucursal' => $nombre_sucursal,
        );
        $this->session->set_userdata('usuario_sesion', $usuario_sesion);

        $this->db->where('id', $idImpresora);
        $res = $this->db->update('impresora', array('activo' => 1));
        return $res;
    }

    public function set_sesion_usuario($datosUsuario, $idSucursal)
    {
        $usuario_data = array(
            'id' => $datosUsuario->id,
            'ci' => $datosUsuario->ci,
            'nombre' => $datosUsuario->nombre_usuario,
            'telf' => $datosUsuario->telefono,
            'cargo' => $datosUsuario->cargo,
            'sucursal' => $idSucursal
        );
        $this->session->set_userdata('usuario_sesion', $usuario_data);
        $this->db->where('id', $datosUsuario->id);
        $this->db->update('usuario', array('activo' => 1));
    }

    public function cerrar_sesion()
    {
        // Recuperar datos de la sesion activa
        $sesion = $this->session->userdata('usuario_sesion');
        if(isset($sesion)) {
            $id_sesion = $sesion['idSesion'];
            $usuario_id = $sesion['idUsuario'];
            $idImpresora = $sesion['id_impresora'];
            $data = array(
                'fecha' => date('Y-m-d H:i:s'),
                'sesion_id' => $id_sesion
            );

            // Insertar en tabla "cierre_sesion"
            $this->db->insert('cierre_sesion', $data);

            // Cambiar el estado del usuario a "0"
            $sql = "UPDATE usuario set activo = ? WHERE id = ?";
            $this->db->query($sql, array(0, $usuario_id));

            $this->db->where('id', $idImpresora);
            $this->db->update('impresora', array('activo' => 0));
        }
    }

    public function obtenerSucursales()
    {
        return $this->db->get('sucursal')->result();
    }

    public function sesionActiva($idusuario)
    {
        $datos = $this->db->get_where('usuario', array('id' => $idusuario))->row();
        if ($datos->activo === 1 or $datos->activo === '1') {
            return true;
        } else {
            return false;
        }
    }

    public function obtnerSesionActiva($idUsuario, $idSucursal)
    {
        $sql_sesion = "select impresora_id from inicio_sesion WHERE usuario_id = ? ORDER BY id DESC LIMIT 1";
        $idImpresora = $this->db->query($sql_sesion, $idUsuario)->row()->impresora_id;

        $sql = "select i.id, i.usuario_id, i.impresora_id, u.ci, u.nombre_usuario, u.cargo, u.telefono, p.marca 
                from impresora p, inicio_sesion i, usuario u WHERE p.id = i.impresora_id and i.usuario_id = u.id 
                and i.usuario_id = ? and i.impresora_id = ? ORDER BY i.id DESC LIMIT 1";
        $res = $this->db->query($sql, array($idUsuario, $idImpresora))->row();
        $nombre_sucursal = $this->db->get_where('sucursal', array('id' => $idSucursal))->row()->sucursal;
        $usuario_sesion = array(
            'idSesion' => $res->id,
            'idUsuario' => $idUsuario,
            'ci' => $res->ci,
            'nombre' => $res->nombre_usuario,
            'cargo' => $res->cargo,
            'telf' => $res->telefono,
            'id_impresora' => $idImpresora,
            'marca' => $res->marca,
            'idSucursal' => $idSucursal,
            'nombre_sucursal' => $nombre_sucursal,
        );
        $this->session->set_userdata('usuario_sesion', $usuario_sesion);
        $this->session->set_userdata('logueado', true);
    }

    public function existe_sucursal()
    {
        return $this->db->query('select count(*)cantidad from sucursal')->row()->cantidad;
    }
}