<?php
/*Llamado a los archivos requeridos de la clase*/
require_once("Controllers/ExcepcionesClub.php");
require_once ("Librerias/Objetos/ObjClub.php");
class ClubModel extends Mysql
{
    private ObjClub $objClub;
    private ErrorsClub $valExcepcionesClub;
    public function __construct()
    {
        parent::__construct();
        $this->valExcepcionesClub = new ErrorsClub();
    }
    /*Funcion: Permite seleccionar un club, recive: 
    *@param int $id_club
    */
    public function selectClub(int $idClub){
        $idClub = $idClub;
        $sql = "SELECT *
                FROM `club` WHERE id_club = $idClub";
        $request = $this->select($sql);
        return $request;
    }
    /*Funcion: Selecciona todos los clubes 
    *No recibe parametros */
    public function selectClubs()
    {

        /*Llamado al metodo select_all donde se ejecuta la consulta a la base de datos
        en la clase Mysql*/
        $request = $this->select_all("SELECT * FROM club WHERE status !=0");
        return $request;
    }
    /*Funcion: Recibe como parametro un Objeto tipo club y procede a insertar un club a la
    base de datos */
    public function insertClub(ObjClub $objClub){
        try {
            //Se asigna al objetio club de la clase el club recibido
            $this->objClub = $objClub;
            $sql = "SELECT * FROM club WHERE
					codigo_club = '{$this->objClub->getCodigoClub()}'";
            $request = $this->select_all($sql);
            $this->valExcepcionesClub->validarQueryInsertar($request);
            $query_insert  = "INSERT INTO club(`codigo_club`, `nombre_club`, `correo_club`,
                                                `asociacion_futbol`, `direccion_club`,
                                                `fecha_fundacion`, `presidente`, `status`)
								  VALUES(?,?,?,?,?,?,?,?)";
            //Ingreso de los datos obtenidos a un arreglo de datos
            $arrData = array($this->objClub->getCodigoClub(),
                $this->objClub->getNombreClub(),
                $this->objClub->getCorreoClub(),
                $this->objClub->getAsociacionFutbol(),
                $this->objClub->getDireccionClub(),
                $this->objClub->getFechaFundacion(),
                $this->objClub->getPresidente(),
                $this->objClub->getStatus());
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }catch (Exception $e){
            $return = $e->getMessage();
        }
        return $return;
    }
    /*Funcion que recibe como parametro un Objeto tipo club y procede a actualizar un club a la
    base de datos */
    public function updateColegiado(ObjClub $objClub){
        $this->objClub = $objClub;
        $sql = "SELECT * FROM club WHERE (id_club = '{$this->objClub->getIdClub()}') ";
        $request = $this->select_all($sql);
        try {
            $this->valExcepcionesClub->validarQueryInsertar($request);
            $sql = "UPDATE club SET codigo_club=?, nombre_club=?, correo_club=?, asociacion_futbol=?,
                            direccion_club=?,fecha_fundacion=?,presidente=?,status=?
							WHERE id_club = '{$this->objClub->getIdClub()}' ";
            //Ingreso de los datos obtenidos a un arreglo de datos
            $arrData = array(
                $this->objClub->getCodigoClub(),
                $this->objClub->getNombreClub(),
                $this->objClub->getCorreoClub(),
                $this->objClub->getAsociacionFutbol(),
                $this->objClub->getDireccionClub(),
                $this->objClub->getFechaFundacion(),
                $this->objClub->getPresidente(),
                $this->objClub->getStatus());

            $request = $this->update($sql,$arrData);
        }catch (Exception $e){
            $request = $e->getMessage();
        }
        return $request;
    }

    /*Funcion: Permite eliminar un club, recive
    *@param int $id_club*/
    public function eliminarClub(int $id_club)
    {
        $id_club = $id_club;
        $sql = "DELETE FROM `club` WHERE id_club = id_club";

        $request = $this->delete($sql);
        return $request;
    }

}
