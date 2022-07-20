<?php

require_once("Controllers/ExcepcionesUsuarios.php");
require_once ("Librerias/Objetos/ObjPersona.php");
class Usuarios extends Controllers{

private ObjPersona $objPersona;
private ErrorsUsuarios $valExcepcionesUsuario;
    public function __construct()
    {
        session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
        parent::__construct();
			$this->valExcepcionesUsuario = new ErrorsUsuarios();
    }
    /*LLamado de la vista y los datos para usar en la vista*/
    public function usuarios(){
        $data['page_id'] = 4;
        $data['page_tag'] = "Usuarios - Sistema Federacion de Arbritos";
        $data['page_title'] = "Administracion de Usuarios ";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "functions_usuarios.js";
       $this->views->getView($this,"usuarios",$data);
    }
    /*Funcion que inicializa los datos recibios por el metodo POST y se lo aplica
    a los datos de los objetos */
    public function asignarDatos(){
        $this->objPersona = new ObjPersona();
        $this->objPersona->setIdPersona(intval($_POST['idUsuario']));
        $this->objPersona->setCedula(strClean($_POST['txtIdentificacion']));
        $this->objPersona->setNombre(ucwords(strClean($_POST['txtNombre'])));
        $this->objPersona->setApellidos(ucwords(strClean($_POST['txtApellido'])));
        $this->objPersona->setTelefono(intval(strClean($_POST['txtTelefono'])));
        $this->objPersona->setEmail(strtolower(strClean($_POST['txtEmail'])));
        $this->objPersona->setTipoId(intval(strClean($_POST['listRolid'])));
        $this->objPersona->setStatus(intval(strClean($_POST['listStatus'])));
    }
    /*Funcion que permite setear un usuario en el sistema */
    public function setUsuario(){
        if($_POST){
            try {
                $this->asignarDatos();
                $this->valExcepcionesUsuario->validarCamposVacios($this->objPersona);
                $this->objPersona->setPassword(empty($_POST['txtPassword']) ? hash("SHA256",passGenerador()) : hash("SHA256",$_POST['txtPassword'])) ;
                $request_user = $this->model->insertUsuario($this->objPersona);
                $this->valExcepcionesUsuario->validarUsuarioExistente($request_user);
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
             }catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
        }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite editar un usuario en el sistema */
    public function editUsuario(){
        if($_POST){
            try {
                $this->asignarDatos();
                $this->valExcepcionesUsuario->validarCamposVacios($this->objPersona);
                $this->objPersona->setPassword(empty($_POST['txtPassword']) ?  : hash("SHA256",$_POST['txtPassword']));
                $request_user = $this->model->updateUsuario($this->objPersona);
                $this->valExcepcionesUsuario->validarUsuarioActualizado($request_user);
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite recuperar todos los usuarios del sistema */
    public function getUsuarios()
    {
        $arrData = $this->model->selectUsuarios();
        for ($i=0; $i < sizeof($arrData); $i++) {
            if($arrData[$i]['status'] == 1)
            {
                $arrData[$i]['status'] = '<span class="badge badge-success" style="background: green">Activo</span>';
            }else{
                $arrData[$i]['status'] = '<span class="badge badge-danger" style="background: red">Inactivo</span>';
            }
                $arrData[$i]['options'] = '<div class="text-center">
				<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="far fa-eye"></i></button>
				<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['idpersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>
				<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>
				</div>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }
    /*Funcion que permite seleccionar un usuario del sistema */
    public function getUsuario(int $idpersona){
        $idusuario = intval($idpersona);
        if($idusuario > RESPUESTA_QUERY)
        {
            $arrData = $this->model->selectUsuario($idusuario);
            $this->valExcepcionesUsuario->validarQuery($arrData);
            try {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());
            }
            //dep($arrResponse);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite eliminar un usuario en el sistema */
    public function delUsuario()
    {
        if($_POST){
            $intIdpersona = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdpersona);
            $this->valExcepcionesUsuario->validarQueryDelete($requestDelete);
            try {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite recuperar la lista de usaurios para crear un colegio
    la llamada de esta funcion esta en el controlador colegiados*/
    public function getSelectUsuarios()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectUsuarios();
        if(count($arrData) > 0 ){
            for ($i=0; $i < count($arrData); $i++) {
                if($arrData[$i]['status'] == 1 ){
                    $htmlOptions .= '<option value="'.$arrData[$i]['idpersona'].'">'.$arrData[$i]['nombres'].'</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
}
?>