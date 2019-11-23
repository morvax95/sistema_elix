<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_usuario extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* --------------------------------------------------
     * Funcion para retornar el id siguiente
     * --------------------------------------------------
     */
    public function next_id(){
        $sql = "SHOW TABLE STATUS LIKE 'usuario' " ;
        $res = $this->db->query($sql);
        return $res->row()->Auto_increment;
    }

    /* --------------------------------------------------------
     * Funcion para obtener los datos un usuario seleccionado
     * --------------------------------------------------------
     * */
    public function obtener_usuario($id_usuario) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $cmd = $this->db->query($sql, array($id_usuario));
        return $cmd->result_array();
    }

    /*-------------------------------------------------------
     * Funcion para obtener el listado de todos los usuarios
     * -------------------------------------------------------
     * */
    public function obtener_usuarios() {
        $cmd = $this->db->get_where('usuario',array('id !='=>1));
        return $cmd->result();
    }

    /*------------------------------------------------------------------------------
     * Obtenemos los usuarios habilitados a excepcion del id =1 ya que es la cuenta por defecto
     *------------------------------------------------------------------------------
     */

    public function getUsuarios(){
        $sql = "SELECT id , nombre_usuario FROM usuario WHERE estado = 1 and id != 1";
        $cmd = $this->db->query($sql);
        return $cmd->result();
    }
    /* ----------------------------------------------------------------
     * Registramos a un usuario y sus privilegios seleccionados
     * ----------------------------------------------------------------
     */
    public function registrar_usuario($usuario,$menu, $lista_sucursales){
        $this->db->trans_start();
        $this->db->insert('usuario',$usuario);
        $respuesta = $this->db->get_where('usuario',array('ci'=>$usuario['ci'], 'nombre_usuario'=>$usuario['nombre_usuario'],'usuario'=>$usuario['usuario']));
        $datosUsuario = $respuesta->row();
        if($usuario['cargo'] != 'ADMINISTRADOR'  ){
            $this->registrar_privilegios_users($menu, $datosUsuario->id);
        }

        foreach ($lista_sucursales as $row){
            $this->db->insert('usuario_sucursal',array('usuario_id'=>$datosUsuario->id,'sucursal_id'=>$row));
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return 'error';
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    /*-----------------------------------------------------------
     * Funcion para editar datos y privilegios de un usuario
     * ----------------------------------------------------------
     */
    public function editar_usuario($usuario, $id, $menu,$lista_sucursales){
        $campos = array(
            'ci'=> $usuario['ci'],
            'nombre_usuario'=> $usuario['nombre_usuario'],
            'telefono'=>$usuario['telefono'],
            'usuario'=>$usuario['usuario']
        );
        $this->db->where('id', $id);
        $res = $this->db->update('usuario',$campos);

        if(!is_null($menu)){
            $this->db->where('usuario_id',$id);
            $this->db->delete('acceso');

            $this->registrar_privilegios_users($menu,$id);
        }

        if(!is_null($lista_sucursales))
        {
            $this->db->where('usuario_id',$id);
            $this->db->delete('usuario_sucursal');

            foreach ($lista_sucursales as $row){
                $this->db->insert('usuario_sucursal',array('usuario_id'=>$id,'sucursal_id'=>$row));
            }
        }
        return $res;
    }

    /*------------------------------------------------------------
     * Funcion para dar de baja a un usuario
     * -----------------------------------------------------------
     */
    public function eliminar($usuario){
        $this->db->where('id', $usuario);
        return $this->db->update('usuario', array('estado'=> 0));
    }

    /*-----------------------------------------------------
     *  Funcion para habilitar a un usuario dado de baja
     * ----------------------------------------------------
     */
    public function reactivar($id){
        $this->db->where('id', $id);
        return $this->db->update('usuario', array('estado'=> 1));
    }

    /*-----------------------------------------------------------------
     * Funcion para obtener todas las funciones hijas de la tabla menu
     *-----------------------------------------------------------------
    */
    public function obtener_privilegios(){
        $sql = "SELECT m.id, m.name FROM menu m WHERE m.parent is not null";
        $res = $this->db->query($sql);
        return $res->result();
    }

    /*-----------------------------------------------------
     * Funcion para registrar privilegios del administrador
     *-----------------------------------------------------
     * ESTA FUNCION NO SE ESTA USANDO
     */
    public function registrar_privilegios_admin($usuario){
        $sql = "SELECT m.id, m.name FROM menu m WHERE m.parent is not null";
        $res = $this->db->query($sql);
        $datos = $res->result();

        foreach($datos as $row){
            $this->db->insert('acceso', array('menu_id'=>$row->id, 'usuario_id'=>$usuario));
        }
    }

    /* ------------------------------------------------------------------------------
     * Funcion para registrar los privilegios seleccionados del usuario registrado
     * ------------------------------------------------------------------------------
     */
    public function registrar_privilegios_users($funciones, $usuario){
        $modulos = array();
        $index = 0;
        foreach($funciones as $row){
            $respuesta = $this->verificarMenu($row, $usuario);
            if ($respuesta != 'false') {
                /// insertamos el modulo en la tabla acceso
                if (!in_array($respuesta, $modulos)) {
                    $modulos[$index] = $respuesta;
                    $index++;
                    // Aqui insertamos el modulo (padre) del la funcion correspondiente,
                    // este registro se hace solo una ves por cada nuevo modulo
                    $this->db->insert('acceso', array('menu_id' => $respuesta, 'usuario_id' => $usuario));
                }
            }
            // Aqui insertamos la funcion (hijo)
            $this->db->insert('acceso', array('menu_id'=>$row, 'usuario_id'=>$usuario));
        }
    }

    /* ----------------------------------------------------------------------------------
     * Verificacion de menu padre
     * ----------------------------------------------------------------------------------
     * Funcion que verifica si existen un modulo registrado de una funcion hija,
     * si existe = 0 este devuelve false;
     * si existe = 1 se devuelve el id del modulo.
     */
    public function verificarMenu($idmenu, $usuario)
    {
        $sql = "select count(m.parent)existe, m.parent from menu m, acceso a, usuario u where m.id = a.menu_id and a.usuario_id = u.id and u.id = ? and m.id = ?";
        $res = $this->db->query($sql, array($usuario, $idmenu));
        $datos = $res->row();
        $existe = $datos->existe;
        $modulo = $datos->parent;
        if ($existe == 0) {
            return $modulo;
        } else {
            return 'false';
        }
    }

    /*----------------------------------------------------------------
    * Funcion para obtener los privilegios del usuario seleccionado
    *-----------------------------------------------------------------
    */
    public function obtener_privilegios_users($id){
        $sql = "SELECT m.id, m.name FROM menu m, acceso a, usuario u WHERE m.id = a.menu_id and a.usuario_id = u.id and u.id = ?";
        $res = $this->db->query($sql, array($id));
        return $res->result();
    }

    public function obtener_sucursales_seleccionadas($usuario_id){
        $sql = "select s.id from usuario u, usuario_sucursal su, sucursal s where u.id = su.usuario_id and su.sucursal_id = s.id and u.estado = 1 and u.id = ?";
        $res = $this->db->query($sql, array($usuario_id))->result();
        return $res;
    }

    public function activar_inicio_usuario($user){
        $this->db->set('activo', 1);
        $this->db->where('id', $user);
        $this->db->update('usuario');
    }
}