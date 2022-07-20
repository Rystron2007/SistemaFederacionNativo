<?php
require_once ("Librerias/Objetos/ObjColegiado.php");
class ErrorsColegiados extends Controllers{
    private ObjColegiado $objColegiado;
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
    public function validarCamposVacios(ObjColegiado $ojColegiado){
        $this->objColegiado = $ojColegiado;
        if(empty($this->objColegiado->getCodFederacion()) || empty($this->objColegiado->getIdPersona())  )
        {
            throw new Exception('Por favor revisar los campos existe uno Vacio'.$this->objColegiado->getCodFederacion().' '.$this->objColegiado->getIdPersona() );
        }
        return true;
    }
    public function validarColegiadoExistente($request_user){
        if($request_user == 'exist'){
            throw new Exception('¡Atención! el colegiado ya existe, ingrese otro.');
        }
        return true;
    }
    public function validarColegiadoActualizado($request_user){
        if($request_user <= 0 )
        {
            throw new Exception('No es posible almacenar los datos. Error interno intente mas tarde');
        }
        return true;
    }
    public function validarQueryDelete($request){
        if($request != true)
        {
            throw new Exception('Error al eliminar el Colegiado.');
        }
        return true;
    }
}
?>