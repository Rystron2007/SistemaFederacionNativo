<?php
//Direccion del sistema 
const BASE_URL = "http://localhost:8081/SistemaFederacion/";
const RESPUESTA_QUERY = 0;
const RESPUESTA_QUERY_EXISTE = 'exist';
const RESPUESTA_QUERY_OK = 'ok';
//Zona horaria 
date_default_timezone_set('America/Guayaquil');

//Datos de Conexion con la Base de datos
const DB_SERVIDOR = "162.241.62.205";
const DB_BASE_DATOS= "proye244_federacion_arbritos";
const DB_USUARIO= "proye244_0927218487";
const DB_PASSWORD = "Oscar-1989";
const DB_CHARSET = "charset=utf8";

//Variable decimal y millar ejemplo 31,1111.00
const SPD = ".";
const SPM = ",";

//Simbolo moneda 
const SMONEY = "$";

//Datos envio de correo
const NOMBRE_REMITENTE = "Departamento de Sistemas Grupo 2 Construcción de Software";
const EMAIL_REMITENTE = "no-reply@feap.gob.ec";
const NOMBRE_EMPESA = "Federación de Arbritos del Ecuador";
const WEB_EMPRESA = "http://grupo2.proyectosoftware.com";

?>