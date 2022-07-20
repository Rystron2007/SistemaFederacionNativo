<?php
require_once ("Librerias/Objetos/ObjColegiado.php");
class ErrorsClub extends Controllers{
    private ObjClub $objClub;
    public $mensaje;

    public function __construct()
    {
        parent::__construct();
    }

    public function notFound(){
        $data['tag_page'] = "Error";
        $data['page_title'] = "Página de Inicio No funciaona";
        $data['page_name'] = "listo";
        $data['page_mensaje'] = $this->mensaje;
        $this->views->getView($this,"error", $data);
    }
    public function validarQuery($request){
        if(empty($request))
        {
            throw new Exception('Datos no encontrados.');
        }
        return true;
    }

    public function validarCamposVacios(ObjClub $ojCclub){
        $this->objClub = $ojCclub;
        if(empty($this->objClub->getCodigoClub()) || empty($this->objClub->getNombreClub()) || empty($this->objClub->getCorreoClub()) )
        {
            throw new Exception('Por favor revisar los campos Codigo - Nombre - Correo existe uno Vacio' );
        }
        return true;
    }

    public function validarClubExistente($request_user){
        if($request_user == 'exist'){
            throw new Exception('¡Atención! el club ya existe, ingrese otro.');
        }
        return true;
    }

    public function validarClubActualizado($request_user){
        if($request_user <= 0 )
        {
            throw new Exception('No es posible almacenar los datos. Error interno intente mas tarde');
        }
        return true;
    }

    public function validarQueryDelete($request){
        if($request != true)
        {
            throw new Exception('Error al eliminar el Club.');
        }
        return true;
    }


    public function validarQueryInsertar($request){
        if(!empty($request))
        {
            throw new Exception('exist');
        }
        return true;
    }





}
