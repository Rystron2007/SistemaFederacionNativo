<?php


class ObjClub
{
    private int $id_club;
    private string $codigo_club;
    private string $nombre_club;
    private string $correo_club;
    private string $asociacion_futbol;
    private string $direccion_club;
    private string $fecha_fundacion;
    private string $presidente;
    private int $status;

    /**
     * ObjClub constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdClub(): int
    {
        return $this->id_club;
    }

    /**
     * @param int $id_club
     * @return ObjClub
     */
    public function setIdClub(int $id_club): ObjClub
    {
        $this->id_club = $id_club;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoClub(): string
    {
        return $this->codigo_club;
    }

    /**
     * @param string $codigo_club
     * @return ObjClub
     */
    public function setCodigoClub(string $codigo_club): ObjClub
    {
        $this->codigo_club = $codigo_club;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombreClub(): string
    {
        return $this->nombre_club;
    }

    /**
     * @param string $nombre_club
     * @return ObjClub
     */
    public function setNombreClub(string $nombre_club): ObjClub
    {
        $this->nombre_club = $nombre_club;
        return $this;
    }

    /**
     * @return string
     */
    public function getCorreoClub(): string
    {
        return $this->correo_club;
    }

    /**
     * @param string $correo_club
     * @return ObjClub
     */
    public function setCorreoClub(string $correo_club): ObjClub
    {
        $this->correo_club = $correo_club;
        return $this;
    }

    /**
     * @return string
     */
    public function getAsociacionFutbol(): string
    {
        return $this->asociacion_futbol;
    }

    /**
     * @param string $asociacion_futbol
     * @return ObjClub
     */
    public function setAsociacionFutbol(string $asociacion_futbol): ObjClub
    {
        $this->asociacion_futbol = $asociacion_futbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getDireccionClub(): string
    {
        return $this->direccion_club;
    }

    /**
     * @param string $direccion_club
     * @return ObjClub
     */
    public function setDireccionClub(string $direccion_club): ObjClub
    {
        $this->direccion_club = $direccion_club;
        return $this;
    }

    /**
     * @return string
     */
    public function getFechaFundacion(): string
    {
        return $this->fecha_fundacion;
    }

    /**
     * @param string $fecha_fundacion
     * @return ObjClub
     */
    public function setFechaFundacion(string $fecha_fundacion): ObjClub
    {
        $this->fecha_fundacion = $fecha_fundacion;
        return $this;
    }

    /**
     * @return string
     */
    public function getPresidente(): string
    {
        return $this->presidente;
    }

    /**
     * @param string $presidente
     * @return ObjClub
     */
    public function setPresidente(string $presidente): ObjClub
    {
        $this->presidente = $presidente;
        return $this;
    }

     /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return ObjClub
     */
    public function setStatus(int $status): ObjClub
    {
        $this->status = $status;
        return $this;
    }

}