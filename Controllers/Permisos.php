<?php
class Permisos extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }
    /*Funcion que recupera los permisol que tiene el usuairo */
    public function getPermisosRol(int $idrol)
		{
            $rol_id = intval($idrol);
        if($rol_id > 0){
            $arrModulos = $this->model->selectModulos();
            $arrPermisosRol = $this->model->selectPermisosRol($rol_id);
            $arrPermisos = array('read' => 0, 'write' => 0,'update' => 0, 'delete' => 0);
            $arrPermisoRol = array('id_rol' => $rol_id);
            if(empty($arrPermisosRol)){
                for ($i=0; $i < count($arrModulos); $i++){
                    $arrModulos[$i]['permisos'] = $arrPermisos;    
                }
            }else{
                for ($i=0; $i < count($arrModulos); $i++){
                    $arrPermisos = array(   'read' => $arrPermisosRol[$i]['read_permiso'],
                                            'write' => $arrPermisosRol[$i]['write_permiso'],
                                            'update' => $arrPermisosRol[$i]['update_permiso'],
                                            'delete' => $arrPermisosRol[$i]['delete_permiso'],
                                        );
                    if($arrModulos[$i]['idmodulo'] == $arrPermisoRol[$i]['id_modulo']){
                        $arrModulos[$i]['permisos'] = $arrPermisos;
                    }
                }
            }
				$arrPermisoRol['modulos'] = $arrModulos;
				$html = getModal("modalPermisos",$arrPermisoRol);
			}
			die();
		}
		/*Funcion para setear los permisos al usuario */
    public function setPermisos(){
        if($_POST){
            $intIdrol = intval($_POST['id_rol']);
            $modulos = $_POST['modulos'];
            $this->model->deletePermisos($intIdrol);
            foreach ($modulos as $modulo) {
                $idModulo = $modulo['idmodulo'];
                $read = empty($modulo['read']) ? 0 : 1;
                $write = empty($modulo['write']) ? 0 : 1;
                $update = empty($modulo['update']) ? 0 : 1;
                $delete = empty($modulo['delete']) ? 0 : 1;
                $requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $read, $write, $update, $delete);
            }
            if($requestPermiso > 0){
                $arrResponse = array('status' => true, 'msg' => 'Permisos Guardados Correctamente');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'No es posible asignar los permisos');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>