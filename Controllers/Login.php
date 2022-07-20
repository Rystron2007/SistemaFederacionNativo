<?php 
	require_once("Controllers/ExcepcionesLogin.php");
	class Login extends Controllers{
		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'dashboard');
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_tag'] = "Login - Federación Arbritos";
			$data['page_title'] = "Federación de Arbritos";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}
		/*Funcion que permite realizar el login a un usuario validando el usuario y el password*/
		public function loginUser(){
			$validarExcepcionesLogin = new Errors();
			if($_POST){
			try {
				$validarExcepcionesLogin->validarCamposVacios($_POST['txtEmail'],$_POST['txtPassword']);
				$strUsuario  =  strtolower(strClean($_POST['txtEmail']));
				$strPassword = hash("SHA256",$_POST['txtPassword']);
				$requestUser = $this->model->loginUser($strUsuario, $strPassword);
				$validarExcepcionesLogin->validarUsuarioExiste($requestUser);  
				$arrData = $requestUser;						
				$validarExcepcionesLogin->validarStatus($arrData);
				$_SESSION['idUser'] = $arrData['idpersona'];
				$_SESSION['login'] = true;
				$arrData = $this->model->sessionLogin($_SESSION['idUser']);
				$_SESSION['userData']= $arrData;
				//sessionUser($_SESSION['idUser']);			
				$arrResponse = array('status' => true, 'msg' => 'ok');
			} catch (Exception $e) {							
				$arrResponse = array('status' => false, 'msg' => $e->getMessage()); 
			}
		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
	die();
}
    /*Funcion para resetear password (disponible en 2da entrega del proyecto)*/
    public function resetPass(){
			$validarExcepcionesLogin = new Errors();
			if($_POST){
				error_reporting(0);
				try {
					$validarExcepcionesLogin->validarCampoEmail($_POST['txtEmailReset']);
					$token = token();
					$strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);
					$validarExcepcionesLogin->validarVacio($arrData);
					$idpersona = $arrData['idpersona'];
					$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];
					$url_recovery = base_url().'login/confirmUser/'.$strEmail.'/'.$token;
					
					$requestUpdate = $this->model->setTokenUser($idpersona,$token);

					$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE,
											 'url_recovery' => $url_recovery);	
					$validarExcepcionesLogin->validarRespuestaUpdate($requestUpdate);
					$sendEmail = sendEmail($dataUsuario,'email_cambioPassword');
					$validarExcepcionesLogin->validarRespuestaUpdate($sendEmail);					

					$arrResponse = array('status' => true, 
												 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');

				} catch (Exception $e) {
					$arrResponse = array('status' => false, 'msg' => $e->getMessage()); 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        /*Funcion para confirmar el cambio de contraseña (Funcion disponible en el 2do parcial) */
		public function confirmUser(string $params){
			$validarExcepcionesLogin = new Errors();
			try {
				$validarExcepcionesLogin->validarVacioConfirm($params);
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				$arrResponse = $this->model->getUsuario($strEmail,$strToken);
				$validarExcepcionesLogin->validarVacioConfirm($arrResponse);

				$data['page_tag'] = "Cambiar contraseña";
				$data['page_name'] = "cambiar_contrasenia";
				$data['page_title'] = "Cambiar Contraseña";
				$data['email'] = $strEmail;
				$data['token'] = $strToken;
				$data['idpersona'] = $arrResponse['idpersona'];
				$data['page_functions_js'] = "functions_login.js";
				$this->views->getView($this,"cambiarPass",$data);
			
			} catch (Exception $e) {
				header('Location: '.base_url());
			}			
			die();
		}
        /*Funcion para ccambio de contraseña (Funcion disponible en el 2do parcial) */
		public function setPassword(){
			
			$validarExcepcionesLogin = new Errors();
			try {
				$intIdpersona = intval($_POST['idUsuario']);
				$strPassword = $_POST['txtPassword'];
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];
				$strEmail = strClean($_POST['txtEmail']);
				$strToken = strClean($_POST['txtToken']);
				//Validaciones de campos
				$validarExcepcionesLogin->validarCamposReset($intIdpersona,$strEmail,$strToken,$strPassword,$strPasswordConfirm);
				$validarExcepcionesLogin->validarPassIguales($strPassword,$strPasswordConfirm);

				$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
				//Validaciones de respuestas
				$validarExcepcionesLogin->validarRespuestaReset($arrResponseUser);
				$strPassword = hash("SHA256",$strPassword);
				$requestPass = $this->model->insertPassword($intIdpersona,$strPassword);
				//Validaciones de procesos
				$validarExcepcionesLogin->validarProcesoReset($requestPass);
				$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito.');
			} catch (Exception $e) {
				$arrResponse = array('status' => false, 'msg' => $e->getMessage()); 
			}
					
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
	}
 ?>