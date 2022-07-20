<?php
require_once("Librerias/Objetos/ObjRoles.php");
require_once("Controllers/ExcepcionesRoles.php");
class Roles extends Controllers implements Crud{
    private ErrorsRoles $valExcepcionesRoles;
    private ObjRoles $objRoles;
    public function __construct()
    {
        session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
        parent::__construct();
        $this->valExcepcionesRoles = new ErrorsRoles();
    }
    //Controlador para crear la vista 
    public function roles(){
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles de Usuario";
        $data['page_name'] = "roles";
        $data['page_title'] = " Roles Usuario <small> Federación </small>";
        $data['page_functions_js'] = "functions_roles.js";
       $this->views->getView($this,"roles",$data);
    }
    public function asignarDatos(){
        $this->objRoles = new ObjRoles();
        $this->objRoles->setIdRol(intval($_POST['id_rol']));
        $this->objRoles->setRol(strClean($_POST['txtNombre']));
        $this->objRoles->setDescripcion(strClean($_POST['txtDescripcion']));
        $this->objRoles->setStatus(intval($_POST['listStatus']));

    }
    #----------------- seccion ingresos ---------------------#
    /*
    En esta primera seccion se van a establecer las funciones Generales 
    las cuales van a permitir Agregar Acciones, Obtener todos los registros,
    Obterner 1 registro y Agregar 1 registro     
    */

    //Funcion para agregar los botones a la tabla 
    public function addAcciones($arrData){
        for ($i=0; $i < count($arrData); $i++) { 
            //Validacion del estado del registro para mostrar el nombre en la tabla 
            $arrData = $this->changeEtiquetas($i,$arrData);
            //Accion para agregar los botones de accion a los registros de la tabla para poder ser utilizados. 
            $arrData[$i]['options'] = '<div class="text-center">
            <button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermiso('.$arrData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>
            <button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['id_rol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
            </div>';
        }
        return $arrData;
    }

    //Funcion para Consultar un Rol Unico 
    public function getIndividual(int $id_rol)
    {
        //Convertimos lo que se recibe en un entero y se limpia 
        $intIdRol = intval((strClean($id_rol)));
        try {
            //Se arma un arreglo para recibir los datos del rol
            $arrData = $this->model->selectRol($intIdRol);
            $this->valExcepcionesRoles->validarQuery($arrData);
            //Se llama a la funcion para que agregue la respuesta
            $arrResponse = array('status' => true, 'data' => $arrData);
        }catch (Exception $e){
            $arrResponse = array('status' => true, 'msg' => $e->getMessage());
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Funcion para Consultar todos los ROLES
    public function getAll()
    {
        //Asignacion del los datos obtenidos 
        $arrData = $this->model->selectRoles();
        //Recorrido del array de datos recibidos de la base de datos. 
        $arrData = $this->addAcciones($arrData);
        //Impresion de los datos en formato JSON y mostrar en la tabla
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSelectRoles()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if(count($arrData) > 0 ){
            for ($i=0; $i < count($arrData); $i++) { 
                if($arrData[$i]['status'] == 1 ){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_rol'].'">'.$arrData[$i]['nombre_rol'].'</option>';
                }
            }
        }
        echo $htmlOptions;
        die();		
    }


    //Funcion para Agregar un nuevo RoL
    public function setRegistro(){

        if($_POST) {
            try {
                $this->asignarDatos();
                $this->valExcepcionesRoles->validarCamposVacios($this->objRoles);
                $request_rol = $this->model->insertRol($this->objRoles);
                $this->valExcepcionesRoles->validarRolExistente($request_rol);
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Funcion para editar un Rol
    public function editRegistro(){

        if($_POST) {
            try {
                $this->asignarDatos();
                $this->valExcepcionesRoles->validarCamposVacios($this->objRoles);
                $request_rol = $this->model->updateRol($this->objRoles);
                $this->valExcepcionesRoles->validarRolActualizado($request_rol);
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            } catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    //Funcion para Eliminar un ROL 
    public function delRegistro(){
        if($_POST){
            $intId_Rol = intval($_POST['id_rol']);
            $request_Delete = $this->model->deleteRol($intId_Rol);
            $arrResponse = $this->respuestaArrayDel($request_Delete);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    #----------------- seccion funciones de validacion ---------------------#
    /*
    Estas funciones sirven para cumplir con los principios SOLID de segmentacion de operaciones 
    por funciones. 
    */
    //Funcion de Respuestas a las operacione de Insertar y Actualizar 
    public function respuestasOperaciones($request_rol, $tipoOperacion)
    {
        if($request_rol > RESPUESTA_QUERY){
            //mensaje si la respuesta es positiva
            $arrResponse = $this->validarIngresoActualizacion($tipoOperacion);

        }else if($request_rol == RESPUESTA_QUERY_EXISTE){
            //Mensaje si el rol es igual a otro
            $arrResponse = array('status' => false, 'msg' => '¡Atención el Rol ya Existe!');
        }else{
            //Mensaje de fallo
            $arrResponse = array('status' => true, 'msg' => 'No es Posible Almcenar los Datos');
        }
        return $arrResponse;
    }

    public function validarIngresoActualizacion($tipoOperacion)
    {
        if($tipoOperacion == RESPUESTA_QUERY){
            $arrResponse = array('status' => true, 'msg' => 'Datos Guardados Correctamente');
        }else{
            $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente');
        }
        return $arrResponse;
    }
    //Funcion para cambiar el valor de Status por un mensaje 
    public function changeEtiquetas($i, $arrData){
        if($arrData[$i]['status'] == 1)
        {
            $arrData[$i]['status'] = '<span class="badge badge-success" style="background: green">Activo</span>';
        }else{
            $arrData[$i]['status'] = '<span class="badge badge-danger" style="background: red">Inactivo</span>';
        }
        return $arrData;
    }
   
    //Funcion para la respuesta del query de consulta general
    public function addRespuesta($arrData)
    {
        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no Encontrados.');
        }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        return $arrResponse;
    }
   
    //Funcion para la respuesta de esta1do de Eliminacion 
    public function respuestaArrayDel($request_Delete){
        if($request_Delete == RESPUESTA_QUERY_OK){
            $arrResponse = array('status' => true, 'msg' => 'Se ha Eliminado el ROL.');
        }else  if($request_Delete == RESPUESTA_QUERY_EXISTE){
            $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol Asociado a Usuarios.');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al Eliminar el Rol.');
        }
        return $arrResponse;
    }
}
?>