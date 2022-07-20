<?php
class ObjRoles{

    private int $idRol;
    private $rol;
    private $descripcion;
    private $status;

    /**
     * ObjRoles constructor.
     */

    public function __construct()
    {

    }
    /**
     * ObjRoles constructor.
     * @param $idRol
     * @param $rol
     * @param $descripcion
     * @param $status
     */


    /**
     * @return mixed
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * @param mixed $idRol
     */
    public function setIdRol($idRol): void
    {
        $this->idRol = $idRol;
    }

    /**
     * @return mixed
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param mixed $rol
     */
    public function setRol($rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}
?>