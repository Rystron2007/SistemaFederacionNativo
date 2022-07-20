<?php
require_once("Controllers/ExcepcionesColegiados.php");
require_once ("Librerias/Objetos/ObjColegiado.php");
class Colegiados extends Controllers implements Crud
{
    private ObjColegiado $objColegiado;
    private ErrorsColegiados $valExcepcionesColegiados;
    public function __construct()
    {
        session_start();
        //session_regenerate_id(true);
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
        $this->valExcepcionesColegiados = new ErrorsColegiados();
    }
    /*LLamado de la vista y los datos para usar en la vista*/
    public function colegiados(){
        $data['page_id'] = 10;
        $data['page_tag'] = "Colegiados - Sistema Federacion de Arbritos";
        $data['page_title'] = "Administracion de Colegiados ";
        $data['page_name'] = "colegiados";
        $data['page_functions_js'] = "functions_colegiados.js";
        $this->views->getView($this,"colegiados",$data);
    }
    /*Funcion que inicializa los datos recibios por el metodo POST y se lo aplica
    a los datos de los objetos */
    public function asignarDatos(){
        $this->objColegiado = new ObjColegiado();
        $this->objColegiado->setIdColegiado(intval($_POST['idColegiado']));
        $this->objColegiado->setIdPersona(intval($_POST['listUsuarios']));
        $this->objColegiado->setCodFederacion(strClean($_POST['txtFederacion']));
        $this->objColegiado->setStatus(intval(strClean($_POST['listStatus'])));
    }
    /*Funcion que permite seleccionar un colegiado del sistema */
    public function getIndividual(int $id)
    {
        $idColegiado = intval($id);
        if($idColegiado > RESPUESTA_QUERY)
        {
            $arrData = $this->model->selectColegiado($idColegiado);
            try {
            $this->valExcepcionesColegiados->validarQuery($arrData);

                $arrResponse = array('status' => true, 'data' => $arrData);
            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
/*Funcion que permite recuperar todos los colegiados del sistema */
    public function getAll()
    {
        $arrData = $this->model->selectColegiados();


        for ($i=0; $i < sizeof($arrData); $i++) {
            if($arrData[$i]['status'] == 1)
            {
                $arrData[$i]['status'] = '<span class="badge badge-success" style="background: green">Activo</span>';
            }else{
                $arrData[$i]['status'] = '<span class="badge badge-danger" style="background: red">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
				<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewColegiado('.$arrData[$i]['id_colegiado'].')" title="Ver Colegiado"><i class="far fa-eye"></i></button>
				<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditColegiado('.$arrData[$i]['id_colegiado'].')" title="Editar Colegiado"><i class="fas fa-pencil-alt"></i></button>
				<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelColegiado('.$arrData[$i]['id_colegiado'].')" title="Eliminar Colegiado"><i class="far fa-trash-alt"></i></button>
				</div>';
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }
    /*Funcion que permite setear un colegiado en el sistema */
    public function setRegistro()
    {
        if($_POST){
            try {
                $this->asignarDatos();
                $this->valExcepcionesColegiados->validarCamposVacios($this->objColegiado);
                $request_colegiado = $this->model->insertColegiado($this->objColegiado);
                $this->valExcepcionesColegiados->validarColegiadoExistente($request_colegiado);
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            }catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
                //$arrResponse = array("status" => false, "msg" => $this->objColegiado->getIdPersona());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite editar un colegiado en el sistema */
    public function editRegistro()
    {
        if($_POST){
            try {
                $this->asignarDatos();
                $this->valExcepcionesColegiados->validarCamposVacios($this->objColegiado);
                $request_colegiado = $this->model->updateColegiado($this->objColegiado);
                $this->valExcepcionesColegiados->validarColegiadoActualizado($request_colegiado);
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite eliminar un colegiado en el sistema */
    public function delRegistro()
    {
        if($_POST){
            $intIdColegiado = intval($_POST['id_colegiado']);

            $requestDelete = $this->model->deleteColegiado($intIdColegiado);
            try {
            $this->valExcepcionesColegiados->validarQueryDelete($requestDelete);

                $arrResponse = array('status' => true, 'msg' => 'Datos Eliminados correctamente.');

            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());

            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
