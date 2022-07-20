<?php


class ObjColegiado
{
    private int $idColegiado;
    private int $idPersona;
    private string $codFederacion;
    private int $status;

    /**
     * ObjColegiado constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdColegiado(): int
    {
        return $this->idColegiado;
    }

    /**
     * @param int $idColegiado
     * @return ObjColegiado
     */
    public function setIdColegiado(int $idColegiado): ObjColegiado
    {
        $this->idColegiado = $idColegiado;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdPersona(): int
    {
        return $this->idPersona;
    }

    /**
     * @param int $idPersona
     * @return ObjColegiado
     */
    public function setIdPersona(int $idPersona): ObjColegiado
    {
        $this->idPersona = $idPersona;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodFederacion(): string
    {
        return $this->codFederacion;
    }

    /**
     * @param string $codFederacion
     * @return ObjColegiado
     */
    public function setCodFederacion(string $codFederacion): ObjColegiado
    {
        $this->codFederacion = $codFederacion;
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
     * @return ObjColegiado
     */
    public function setStatus(int $status): ObjColegiado
    {
        $this->status = $status;
        return $this;
    }


}