<?php
require_once ("Librerias/Objetos/ObjPersona.php");
class ErrorsUsuarios extends Controllers{
    private ObjPersona $objPersona;
    public $mensaje;

    public function __construct()
    {
        parent::__construct();
    }
    public function notFound(){
        $data['tag_page'] = "Error";
        $data['page_title'] = "Página de Inicio funciaona";
        $data['page_name'] = "listo";
        $data['page_mensaje'] = $this->mensaje;
        $this->views->getView($this,"error", $data);
    }
    //Funcion que valida los campos de usuario

    public function validarCamposVacios(ObjPersona $objPersona){
        $this->objPersona = $objPersona;
        if(empty($this->objPersona->getCedula()) || empty($this->objPersona->getNombre()) || empty($this->objPersona->getApellidos()) )
        {
            throw new Exception('Por favor revisar los campos existe uno Vacio');
        }
        return true;
    }


    public function validarUsuarioExistente($request_user){
        if($request_user == 'exist'){
        throw new Exception('¡Atención! el email o la identificación ya existe, ingrese otro.');
        }
        return true;
    }
    public function validarUsuarioAgregado($request_user){
        if($request_user == 0){
            throw new Exception('No es posible almacenar los datos. Error interno intente mas tarde');
        }
        return true;
    }
    public function validarUsuarioActualizado($request_user){
        if($request_user <= 0 )
        {
            throw new Exception('No es posible almacenar los datos. Error interno intente mas tarde');
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
    public function validarQuery($request){
        if(empty($request))
        {
            throw new Exception('Datos no encontrados.');
        }
        return true;
    }
    public function validarQueryDelete($request){
        if($request != true)
        {
            throw new Exception('Error al eliminar el usuario.');
        }
        return true;
    }

}
?>