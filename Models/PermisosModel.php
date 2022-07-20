<?php
    class PermisosModel extends Mysql{

        public function __construct()
        {
           parent::__construct();
        }
        /*Seleccionamos todos los modulos*/
        public function selectModulos(){
            $sql = "SELECT * FROM modulo WHERE status != 0";
            return $this->select_all($sql);
        }
        /*Seleccionamos los permisos que estan asociados a un determinado rol*/
        public function selectPermisosRol(int $idRol){
            $sql = "SELECT * FROM permisos WHERE id_rol = '$idRol'";
            return $this->select_all($sql);
        }
        /*Eliminamos permisos de un determinado usuario*/
        public function deletePermisos(int $id_rol)
        {
            $sql = "DELETE FROM permisos WHERE id_rol = '$id_rol'";
            return $this->delete($sql);
        }
        /*Insertamos permisos recibiendo los permisos por parametros*/
        public function insertPermisos(int $intIdrol, int $idModulo, int $read, int $write, int $update, int $delete)
        {
            $query_insert = "INSERT INTO `permisos`(`id_rol`, `id_modulo`, `read_permiso`, `write_permiso`, `update_permiso`, `delete_permiso`) VALUES (?,?,?,?,?,?)";
            $arrData = array($intIdrol, $idModulo,$read,$write,$update,$delete);
            return $this->insert($query_insert,$arrData);
        }
    }
?>