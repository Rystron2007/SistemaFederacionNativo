<?php
class Errors extends Controllers{
    public $mensaje;
    public $requestUser;
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
    //Funcion que valida la existencia del usuario 
    public function validarUsuarioExiste($requestUser){
    if(empty($requestUser)){
        throw new Exception('El usuario o la contraseña es incorrecto.');
    }
    return true;    }
    //Validar campos Vacios 
    public function validarCamposVacios($user, $pass){
        if(empty($user) || empty($pass)){
            throw new Exception('Error de datos');
        }
        return true;      }
    //Validar el estado de la respuesta
    public function validarStatus($arrData){
        if($arrData['status'] != 1){
            throw new Exception('Usuario inactivo');
        }
        return true;    }
    public function validarCampoEmail($user){
        if(empty($user)){
            throw new Exception('Escribir su correo Electronico para Reiniciar');
        }
        return true;      }
    public function validarVacio($arrData){
        if(empty($arrData)){
            throw new Exception('Usuario no existente');
        }
        return true;    }
    public function validarRespuestaUpdate($requestUpdate){
        if($requestUpdate == false){
            throw new Exception('No es posible realizar el proceso, intenta más tarde.');
        } return true;
    }
    public function validarVacioConfirm($params){
        if(empty($params)){
            throw new Exception('parametros');
        }
        return true;    
    }
    public function validarCamposReset($id,$email,$token,$pass,$confirPass){
        if(empty($id) || empty($email) || empty($token) || empty($pass) || empty($confirPass)){
            throw new Exception('Error datos Vacios');
        }
        return true;
    }
    public function validarPassIguales($password, $passwordConfirm){
        if($password != $passwordConfirm){
            throw new Exception('Las contraseñas no son iguales.');
        }
        return true;
    }
    public function validarRespuestaReset($arrResponseUser){
        if(empty($arrResponseUser)){
            throw new Exception('Error de datos.');
        }
    }
    public function validarProcesoReset($requestPass){
        if($requestPass == false){
            throw new Exception('No es posible realizar el proceso, intente más tarde.');
        }
    }
}
?>