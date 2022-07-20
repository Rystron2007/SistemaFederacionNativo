<?php
/*Llamado a los archivos requeridos de la clase*/
require_once("Controllers/ExcepcionesColegiados.php");
require_once ("Librerias/Objetos/ObjColegiado.php");
class ColegiadosModel extends Mysql
{
    private ObjColegiado $objetoColegiado;
    private ErrorsColegiados $valExcepcionesColegiados;
    public function __construct()
    {
        parent::__construct();
        $this->valExcepcionesColegiados = new ErrorsColegiados();
    }
    /*Funcion que recibe como parametro un Objeto tipo colegiado y procede a insertar un colegiado a la
        base de datos */
    public function insertColegiado(ObjColegiado $objetoColegiado){
        try {
            $this->objetoColegiado = $objetoColegiado;
            $sql = "SELECT * FROM colegiado WHERE 
					id_persona = '{$this->objColegiado->getIdPersona()}'";
            $request = $this->select_all($sql);
            $this->valExcepcionesColegiados->validarQueryInsertar($request);
            $query_insert  = "INSERT INTO colegiado(`id_persona`, `codigo_federacion`, `status`) 
								  VALUES(?,?,?)"; 
            $arrData = array($this->objColegiado->getIdPersona(),
                $this->objColegiado->getCodFederacion(),
                $this->objColegiado->getStatus());
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }catch (Exception $e){
            $return = $e->getMessage();
        }
        return $return;
    }

    /*Funcion que recibe como parametro un Objeto tipo colegiado y procede a actualizar un colegiado a la
        base de datos */
    public function updateColegiado(ObjColegiado $objetoColegiado){
        $this->objColegiado = $objetoColegiado;
        $sql = "SELECT * FROM colegiado WHERE (id_persona = '{$this->objColegiado->getIdPersona()}' AND id_colegiado != '{$this->objColegiado->getIdColegiado()}') ";
        $request = $this->select_all($sql);
        try {
            $this->valExcepcionesColegiados->validarQueryInsertar($request);
            $sql = "UPDATE colegiado SET id_persona=?, codigo_federacion=?, status=? 
							WHERE id_colegiado = '{$this->objColegiado->getIdColegiado()}' ";
            $arrData = array($this->objColegiado->getIdPersona(),
                $this->objColegiado->getCodFederacion(),
                $this->objColegiado->getStatus());

            $request = $this->update($sql,$arrData);
        }catch (Exception $e){
            $request = $e->getMessage();
        }
        return $request;
    }
    /*Funcion que selecciona todos los colegiados no recibe parametros */
    public function selectColegiados()
    {
        $sql = "SELECT c.id_colegiado, c.codigo_federacion, c.status, p.idpersona,p.cedula,p.nombres,p.apellidos,p.telefono,p.email_user 
					FROM colegiado c 
					INNER JOIN persona p
					ON c.id_persona = p.idpersona
					WHERE c.status != 0 ";
        return $this->select_all($sql);
    }
    /*Funcion que permite seleccionar un colegiado recibe como parametro el Id del colegiado a seleccionar */
    public function selectColegiado(int $idColegiado){
        $intIdColegiado = $idColegiado;
        $sql = "SELECT c.id_colegiado, c.codigo_federacion, c.status, p.idpersona,p.cedula,p.nombres,p.apellidos,p.telefono,p.email_user,DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro
					FROM colegiado c 
					INNER JOIN persona p
					ON c.id_persona = p.idpersona
					WHERE c.id_colegiado = $intIdColegiado";
        return $this->select($sql);
    }

    /*Funcion que permite eliminar un colegiado recibiendo un ID*/
    public function deleteColegiado(int $idColegiado)
    {
        $this->idColegiado = $idColegiado;
        $sql = "DELETE from colegiado WHERE id_colegiado = $this->idColegiado";
        return $this->delete($sql);
    }

}