<?php
class ObjPersona{
    private int $idPersona;
    private string $cedula;
    private string $nombre;
    private string $apellidos;
    private int $telefono;
    private string $email;
    private string $password;
    private int $tipoId;
    private int $status;

    /**
     * ObjPersona constructor.
     */
    public function __construct()
    {
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
     */
    public function setIdPersona(int $idPersona): void
    {
        $this->idPersona = $idPersona;
    }

    /**
     * @return string
     */
    public function getCedula(): string
    {
        return $this->cedula;
    }

    /**
     * @param string $cedula
     */
    public function setCedula(string $cedula): void
    {
        $this->cedula = $cedula;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getTipoId(): int
    {
        return $this->tipoId;
    }

    /**
     * @param int $tipoId
     */
    public function setTipoId(int $tipoId): void
    {
        $this->tipoId = $tipoId;
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
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }



    
}

?>