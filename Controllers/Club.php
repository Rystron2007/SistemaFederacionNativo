<?php
require_once("Controllers/ExcepcionesClub.php");
require_once ("Librerias/Objetos/ObjClub.php");
class Club extends Controllers implements Crud
{
    private ObjClub $objClub;
    private ErrorsClub $valExcepcionesClub;

    public function __construct()
    {
        session_start();
        //session_regenerate_id(true);
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
        $this->valExcepcionesClub = new ErrorsClub();
    }
    /*LLamado de la vista y los datos para usar en la vista*/
    public function club(){
        $data['page_id'] = 13;
        $data['page_tag'] = "Club - Sistema Federacion de Arbritos";
        $data['page_title'] = "Administracion de Clubes Asociados ";
        $data['page_name'] = "club";
        $data['page_functions_js'] = "functions_club.js";
        $this->views->getView($this,"club",$data);
    }
    /*Funcion que inicializa los datos recibios por el metodo POST y se lo aplica
    a los datos de los objetos */
    public function asignarDatos(){
        $this->objClub = new ObjClub();
        $this->objClub->setIdClub(intval($_POST['idClub']));
        $this->objClub->setCodigoClub(strClean($_POST['txtCodigoClub']));
        $this->objClub->setNombreClub(strClean($_POST['txtNombre']));
        $this->objClub->setCorreoClub(strClean($_POST['txtEmail']));
        $this->objClub->setAsociacionFutbol(strClean($_POST['txtFederacion']));
        $this->objClub->setDireccionClub(strClean($_POST['txtDireccion']));
        $this->objClub->setFechaFundacion($_POST['selectDate']);
        $this->objClub->setPresidente(strClean($_POST['txtPresidente']));
        $this->objClub->setStatus(intval($_POST['listStatus']));
    }
    /*Funcion que permite seleccionar un club del sistema */
    public function getIndividual(int $id)
    {
        $id_club = intval($id);
        if($id_club > RESPUESTA_QUERY)
        {
            $arrData = $this->model->selectClub($id_club);
            try {
                $this->valExcepcionesClub->validarQuery($arrData);

                $arrResponse = array('status' => true, 'data' => $arrData);
            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite recuperar todos los clubes del sistema */
    public function getAll()
    {
        $arrData = $this->model->selectClubs();
        for ($i=0; $i < sizeof($arrData); $i++) {
            if($arrData[$i]['status'] == 1)
            {
                $arrData[$i]['status'] = '<span class="badge badge-success" style="background: green;">Activo</span>';
            }else{
                $arrData[$i]['status'] = '<span class="badge badge-danger" style="background: red;">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
				<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewClub('.$arrData[$i]['id_club'].')" title="Ver Club"><i class="far fa-eye"></i></button>
				<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditClub('.$arrData[$i]['id_club'].')" title="Editar Club"><i class="fas fa-pencil-alt"></i></button>
				<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelClub('.$arrData[$i]['id_club'].')" title="Eliminar Club"><i class="far fa-trash-alt"></i></button>
				</div>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    /*Funcion que permite setear un club en el sistema */
    public function setRegistro()
    {
        if($_POST){
            try {
                $this->asignarDatos();
                $this->valExcepcionesClub->validarCamposVacios($this->objClub);
                $request_club = $this->model->insertClub($this->objClub);
                $this->valExcepcionesClub->validarClubExistente($request_club);
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            }catch (Exception $e) {
                $arrResponse = array("status" => false, "msg" => $e->getMessage());
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    /*Funcion que permite editar un club en el sistema */
    public function editRegistro()
    {
        if($_POST){
        try {
            $this->asignarDatos();
            $this->valExcepcionesClub->validarCamposVacios($this->objClub);
            $request_club = $this->model->updateColegiado($this->objClub);
            $this->valExcepcionesClub->validarClubActualizado($request_club);
            $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
        }catch (Exception $e) {
            $arrResponse = array("status" => false, "msg" => $e->getMessage());
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
        die();
    }
    /*Funcion que permite eliminar un club en el sistema */
    public function delRegistro()
    {
        if($_POST){
            $id_club = intval($_POST['idClub']);

            $requestDelete = $this->model->deleteClub($id_club);
            try {
                $this->valExcepcionesClub->validarQueryDelete($requestDelete);

                $arrResponse = array('status' => true, 'msg' => 'Datos Eliminados correctamente.');

            }catch (Exception $e){
                $arrResponse = array('status' => false, 'msg' => $e->getMessage());

            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}